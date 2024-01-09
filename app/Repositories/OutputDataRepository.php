<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Journal;
use App\Models\JournalItem;
use DateTime;
use Illuminate\Support\Facades\DB;

class OutputDataRepository {

    public function balanceProfit($data, $companyId) {
        try {
            $month = $data['month'];
            $year = $data['year'];
            $type = $data['type'];

            $startDate = $year . "-01-01 00:00:00";
            $monthOfYear = $year . "-" . $month . "-01 00:00:00";

            $where = "
                YEAR(transaction_date) = '" . $year . "' AND MONTH(transaction_date) = '" . $month . "'
             AND deleted_at IS NULL AND approved_at IS NOT NULL
            ";
            if ($type === 'balance_sheet') {
                $dateEnd = new DateTime($monthOfYear);
                $dateEnd->modify('last day of this month');
                $dateEnd = $dateEnd->format('Y-m-d');
                $where = "
                    transaction_date BETWEEN '" . $startDate . "' AND '" . $dateEnd . " 23:59:59'
                    AND deleted_at IS NULL AND approved_at IS NOT NULL AND is_first_balance = 0
                ";
            }

            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT 
                    ca.id,
                    ca.name,
                    ca.code AS category_code,
                    c.id AS coa_id,
                    ca.parent_id,
                    c.account_name AS account_name,
                    c.account_number AS account_code,
                    c.is_active AS is_active,
                    ji.credit AS credit, 
                    ji.debit AS debit,
                    c.account_type AS account_type,
                    ji.is_first_balance AS is_first_balance,
                    posting.id AS posting_id,
                    posting.name AS posting_name
                FROM 
                    coa_categories as ca
                    LEFT JOIN coas AS c ON ca.id = c.category_id AND c.company_id = " . $companyId . "
                    LEFT JOIN coa_postings AS posting ON  posting.id = c.posting_id
                    LEFT JOIN (
                        SELECT account_id, SUM(debit) as debit, SUM(credit) AS credit, is_first_balance
                        FROM journal_items
                        WHERE " . $where . "
                        GROUP BY account_id
                    ) AS ji ON c.id = ji.account_id
                WHERE 
                    ca.label = '" . $type . "' AND ca.flag = 'pt'
                AND c.deleted_at is NULL
                ORDER by ca.id ASC
            ";
            $queryData = DB::SELECT($query);
            $allBalances = $this->getInititalBalance($year, $companyId);
            $parentChildFormat = $this->parentChildFormat($queryData);

            $result = [];
            foreach($parentChildFormat as $element) {
                $find = collect($result)->where('id', $element->id)->first();
                $element->first_category = false;
                if (!$find) {
                    $element->first_category = true;
                }

                if ($element->is_first_balance > 0) {
                    $element->balance = $element->debit;
                } else {
                    if ($element->account_type === 'Debit') {
                        $element->balance = $element->debit - $element->credit;
                    }else {
                        $element->balance = $element->credit - $element->debit;
                    }
                }
                $findBalance = collect($allBalances)->where("account_id", $element->coa_id)->first();
                if ($findBalance !== null) {
                    $element->balance = $element->balance + $findBalance->debit;
                }
                $result[] = $element;
            }

            $postings = [];
            $result = json_decode(json_encode($result), true);
            $response = json_decode(json_encode($result), true);
            foreach ($result as $key => $element) {
                if (!empty($element['first_category']) && !empty($element['account_name'])) {
                    $findIndex = array_search($element['id'], array_column($response, 'id'));
                    
                    $response[$findIndex]['account_name'] = null;
                    $response[$findIndex]['balance'] = 0;
                    
                    // Insert a new element after the found index
                    $element['first_category'] = false;
                    $response[$findIndex+1] = $element;
                }
            }

            if ($type === 'balance_sheet') {
                $responseCalculate = $this->calculateBalance($response, $year, $month);
                if (!$responseCalculate['status']) return $responseCalculate;

                $response = $responseCalculate['data']['response'];
                $asset = collect($response)->where('name', 'ASET')->first();
                $postings[] = [
                    "name" => 'TOTAL ASET',
                    "balance" => $asset !== null ? $asset['balance'] : 0
                ];

                if (collect($response)->where('name', 'KEWAJIBAN DAN MODAL')->first()  !== null) {
                    $totalKewajiban = collect($response)->where('name', 'KEWAJIBAN DAN MODAL')->first();
                    $totalKewajibanBalance = $totalKewajiban['balance'];
                    $postings[] = [
                        "name" => 'TOTAL KEWAJIBAN & MODAL',
                        "balance" => $totalKewajibanBalance
                    ];
                }

            } else if ($type === 'profit_lose') {
                $responseCalculate = $this->calculateBalancePL($response);
                if (!$responseCalculate['status']) return $responseCalculate;

                $responseHandlingPt = $this->handlingFlagPT($responseCalculate['data']);
                if (!$responseHandlingPt['status']) return $responseHandlingPt;

                $response = $responseHandlingPt['data'];
            }
            return resultFunction("", true, [
                "posting" => $postings,
                "accounts" => $response,
                "periode" => $year . "-" . $month
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function getInititalBalance($year, $companyId) {
        $query = "
            SELECT * FROM journal_items WHERE  is_first_balance = 1 AND approved_at IS NOT NULL 
            AND company_id = " . $companyId . "
            AND deleted_at IS NULL AND YEAR(transaction_date) = " . $year;
        $queryData = DB::SELECT($query);
        return $queryData;
    }

    public function parentChildFormat($arr, $parent = null) {
        $result = [];
        foreach ($arr as $inArr) {
            if ($inArr->parent_id ===  $parent) {
                $result[] = $inArr;
                $childrens = $this->parentChildFormat($arr, $inArr->id);
                foreach ($childrens as $child) {
                    $result[] = $child;
                }
            }
        }
        return $result;
    }

    public function calculateBalance($response, $year, $month) {
        try {
            $data = collect($response);
            $categoryList = [
                'KAS' => 0,
                'BANK' => 0,
                'PIUTANG USAHA' => 0,
                'PIUTANG KARYAWAN' => 0,
                'PIUTANG AFILIASI' => 0,
                'PIUTANG PEMEGANG SAHAM' => 0,
                'PIUTANG KEPADA PIHAK KETIGA' => 0,
                'PAJAK DIBAYAR DIMUKA' => 0,
                'BIAYA DIBAYAR DIMUKA' => 0,
                'UANG MUKA PEMBELIAN' => 0,
                'ASET TETAP BERWUJUD' => 0,
                'PENYUSUTAN ASET TETAP BERWUJUD' => 0,
                'ASET TETAP' => 0,
                'HUTANG PAJAK' => 0,
                'HUTANG USAHA' => 0,
                'BIAYA YANG MASIH HARUS DIBAYAR' => 0,
                'HUTANG BANK & LEMBAGA KEUANGAN' => 0,
                'HUTANG AFILIASI' => 0,
                'HUTANG PEMEGANG SAHAM' => 0,
                'HUTANG PIHAK KETIGA' => 0,
                'HUTANG BANK' => 0,
                'KEWAJIBAN JANGKA PANJANG' => 0,
                'MODAL' => 0,
                'KEWAJIBAN DAN MODAL' => 0
            ];

            foreach ($categoryList as $key => $cl) {
                $totalBalance = $data->where('name', $key)->sum('balance');
                $keyColl = $this->getKeyFromCollection($response, $key);
                if ($keyColl !== null) {
                    $response[$keyColl]['balance'] = $totalBalance;
                    $categoryList[$key] = $totalBalance;
                }
            }

            $cashBank = $categoryList['KAS'] + $categoryList['BANK'];
            $response = $this->setResponse($response, $cashBank, 'KAS DAN SETARA KAS');

            $tUtang = $categoryList['PIUTANG USAHA'] + $categoryList['PIUTANG KARYAWAN'] + $categoryList['PIUTANG AFILIASI'] + 
            $categoryList['PIUTANG PEMEGANG SAHAM'] + $categoryList['PIUTANG KEPADA PIHAK KETIGA'];
            $response = $this->setResponse($response, $tUtang, 'PIUTANG');

            $tAsetLancar = $tUtang + $cashBank + $categoryList['PAJAK DIBAYAR DIMUKA'] + $categoryList['BIAYA DIBAYAR DIMUKA'] + 
            $categoryList['UANG MUKA PEMBELIAN'];
            $response = $this->setResponse($response, $tAsetLancar, 'ASET LANCAR');

            $tAsetTidakLancar = $categoryList['ASET TETAP BERWUJUD'] + $categoryList['PENYUSUTAN ASET TETAP BERWUJUD'];
            $response = $this->setResponse($response, $tAsetTidakLancar, 'ASET TIDAK LANCAR');

            $tAset = $tAsetTidakLancar + $tAsetLancar;
            $response = $this->setResponse($response, $tAset, 'ASET');

            $tKewajibanLancar = $categoryList['HUTANG PAJAK'] + $categoryList['HUTANG USAHA'] + $categoryList['BIAYA YANG MASIH HARUS DIBAYAR']
            + $categoryList['HUTANG BANK & LEMBAGA KEUANGAN'] + $categoryList['HUTANG AFILIASI'] + $categoryList['HUTANG PEMEGANG SAHAM']
            + $categoryList['HUTANG PIHAK KETIGA'];
            $response = $this->setResponse($response, $tKewajibanLancar, 'KEWAJIBAN LANCAR');

            $response = $this->setResponse($response, $categoryList['HUTANG BANK'], 'HUTANG BANK');

            $response = $this->setResponse($response, $categoryList['KEWAJIBAN JANGKA PANJANG'], 'KEWAJIBAN JANGKA PANJANG');

            $totalKewajiban = $categoryList['HUTANG BANK'] + $tKewajibanLancar;
            $response = $this->setResponse($response, $totalKewajiban, 'KEWAJIBAN');
            
            $labaRugi = $this->getLabaRugi($year, $month);

            $findIndexModal = collect($response)->where('account_name', 'like', '%laba tahun berjalan%')->first();
            if ($findIndexModal !== null) {
                $response[$findIndexModal]['balance'] = $response[$findIndexModal]['balance'] + $labaRugi;
            }

            $kewajibanModal = $categoryList['MODAL'] + $totalKewajiban;
            $response = $this->setResponse($response, $kewajibanModal, 'KEWAJIBAN DAN MODAL');

            return resultFunction("", true, [
                'response' => $response,
                'coa_categories' => $categoryList
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-CBP: catch " . $e->getMessage());
        }
    }

    public function getLabaRugi($year, $month) {
        try {
            $startDate = $year . "-01-01 00:00:00";
            $endDate = $year . "-" . $month . "-01 00:00:00";
            $dateEnd = new DateTime($endDate);
            $dateEnd->modify('last day of this month');
            $dateEnd = $dateEnd->format('Y-m-d');

            $query = "
            SELECT ca.id,ca.name,ca.code AS category_code,c.id AS coa_id, ca.parent_id,c.account_name AS account_name,
            c.account_number as account_code, ji.credit AS credit, ji.debit AS debit,c.account_type AS account_type, ji.is_first_balance AS is_first_balance,
            posting.id AS posting_id,posting.name AS posting_name
            FROM coa_categories as ca
            LEFT JOIN coas AS c ON ca.id = c.category_id AND c.company_id = 1
            LEFT JOIN coa_postings AS posting ON  posting.id = c.posting_id
            LEFT JOIN (
                SELECT account_id, SUM(debit) as debit, SUM(credit) AS credit, is_first_balance
                FROM journal_items
                WHERE transaction_date BETWEEN '" . $startDate . "' AND '" . $dateEnd . " 23:59:59'
                AND deleted_at IS NULL AND approved_at IS NOT NULL
                GROUP BY account_id
            ) AS ji ON c.id = ji.account_id
            WHERE ca.label = 'profit_lose' AND ca.flag = 'pt'
            ORDER by ca.id ASC
            ";
            $queryData = DB::SELECT($query);

            $parentChildFormat = $this->parentChildFormat($queryData);

            $result = [];
            foreach($parentChildFormat as $element) {
                $find = collect($result)->where('id', $element->id)->first();
                $element->first_category = false;
                if (!$find) {
                    $element->first_category = true;
                }

                if ($element->account_type === 'Debit') {
                    $element->balance = $element->debit - $element->credit;
                }else {
                    $element->balance = $element->credit - $element->debit;
                }
                $result[] = $element;
            }
            $result = $this->updateBalance($result);
            $response = json_decode(json_encode($result), true);
            foreach ($response as $key => $element) {
                if (!empty($element['first_category']) && !empty($element['account_name'])) {
                    $findIndex = array_search($element['id'], array_column($response, 'id'));
                    
                    $response[$findIndex]['account_name'] = null;
                    $response[$findIndex]['balance'] = 0;
                    
                    // Insert a new element after the found index
                    $element['first_category'] = false;
                    $response[$findIndex+1] = $element;
                }
            }

            $response = $this->updateBalanceGroup($response);
            $respCalcPL = $this->calculateBalancePL($response);
            $responseHandlingPt = $this->handlingFlagPT($respCalcPL['data'], true);
            if (!$responseHandlingPt['status']) return $responseHandlingPt;

            return $responseHandlingPt['data'];
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function updateBalanceGroup($arr) {
        foreach ($arr as $key => $item) {
            if ($item['first_category'] === true) {
                $sum = $this->sumBalanceById($arr, $item['id']);
                $arr[$key]['balance'] = $sum;
            }
        }
        return $arr;
    }

    public function sumBalanceById($arr, $id) {
        $sum = collect($arr)->where('id', $id)->sum('balance');
        return $sum;
    }

    public function updateBalance($result) {
        foreach ($result as $key => $rs) {
            $result[$key]->balance = $rs->balance + $this->calculateChildBalance($result, $rs);
        }
        return $result;
    }

    public function calculateChildBalance($arr, $parentId) {
        $sum = 0;
        foreach ($arr as $item) {
            if ($item->parent_id ===  $parentId) {
                $sum = $sum + $item->balance + $this->calculateChildBalance($arr, $item->id);
            }
        }
        return $sum;
    }

    public function setResponse($response, $total, $name) {
        $keyCol = $this->getKeyFromCollection($response, $name);
        if ($keyCol !== null) {
            $response[$keyCol]['balance'] = $total;
        }
        return $response;
    }

    public function calculateBalancePL($response) {
        try {
            $data = collect($response);
            $categoryList = [
                'PENDAPATAN' => 0,
                'RETUR' => 0,
                'BEBAN DILUAR USAHA' => 0,
                'BEBAN POKOK PENDAPATAN' => 0,
                'BEBAN PENJUALAN DAN PEMASARAN' => 0,
                'BEBAN USAHA PERUSAHAAN' => 0,
                'BEBAN GAJI' => 0,
                'BEBAN UTILITAS' => 0,
                'BEBAN OPERASI LAINNYA' => 0,
                'BEBAN PEMELIHARAAN' => 0,
                'BEBAN ADMINISTRASI' => 0,
                'BEBAN PENYUSUTAN' => 0,
                'BEBAN OPERASI PERUSAHAAN' => 0,
                'PENDAPATAN DILUAR USAHA' => 0,
                'PAJAK PENGHASILAN' => 0
            ];

            foreach ($categoryList as $key => $cl) {
                $totalBalance = $data->where('name', $key)->sum('balance');
                $keyColl = $this->getKeyFromCollection($response, $key);
                if ($keyColl !== null) {
                    $response[$keyColl]['balance'] = $totalBalance;
                    $categoryList[$key] = $totalBalance;
                }
            }

            $totalBebanOperasiPerusahaan = $categoryList['BEBAN GAJI'] + $categoryList['BEBAN UTILITAS'] + $categoryList['BEBAN OPERASI LAINNYA']
            + $categoryList['BEBAN PEMELIHARAAN'] + $categoryList['BEBAN ADMINISTRASI'] + $categoryList['BEBAN PENYUSUTAN'];
            $keyCollBebanOperasiPerusahaan = $this->getKeyFromCollection($response, 'BEBAN OPERASI PERUSAHAAN');
            if ($keyCollBebanOperasiPerusahaan > 0) {
                $response[$keyCollBebanOperasiPerusahaan]['balance'] = $totalBebanOperasiPerusahaan;
            }
            
            return resultFunction("", true, [
                "response" => $response,
                'coa_categories' => $categoryList
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-CBP: catch " . $e->getMessage());
        }
    }

    public function getKeyFromCollection($response, $name) {
        $key = null;
        foreach($response as $keyResp => $resp) {
            if ($resp['name'] === $name AND $resp['first_category'] === true) {
                $key = $keyResp;
                break;
            }
        }
        return $key;
    }

    public function calcPercentage($value, $dividen) {
        if ($dividen > 0) {
            return $value * 100 / $dividen;
        }
        return 0;
    }

    public function handlingFlagPT($respCalculate, $isTotal = false) {
        try {
            $response = $respCalculate['response'];
            $categoryList = $respCalculate['coa_categories'];

            $pendapatanBersih = $categoryList['PENDAPATAN'] - $categoryList['RETUR'];
            foreach ($response as $keyR => $resp) {
                $resp['percentage'] = 0;
                if ($resp['name'] === 'PENDAPATAN') {
                    $response[$keyR]['percentage'] = $categoryList['PENDAPATAN'] > 0 ? $this->calcPercentage($resp['balance'], $categoryList['PENDAPATAN']) : 0;
                } else if ($resp['name'] === 'RETUR') {
                    $response[$keyR]['percentage'] = $resp['balance'] > 0 ? $this->calcPercentage($resp['balance'], $categoryList['PENDAPATAN']) : 0;
                } else {
                    $response[$keyR]['percentage'] = $resp['balance'] > 0 ? $this->calcPercentage($resp['balance'], $pendapatanBersih) : 0;
                }
            }

            $resultResp = [];
            foreach ($categoryList as $keyCl => $cl)  {
                $dataR = collect($response)->where('name', $keyCl);
                $dataR = json_decode(json_encode($dataR), true);
                $resultResp[$keyCl] = $dataR;
            }

            $responseFinal = [];
            $responseFinal = array_merge($responseFinal, $resultResp['PENDAPATAN']);
            $responseFinal = array_merge($responseFinal, $resultResp['RETUR']);
            $responseFinal[] = $this->accountObj("PENDAPATAN BERSIH", $pendapatanBersih, $this->calcPercentage($pendapatanBersih, $pendapatanBersih));
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN POKOK PENDAPATAN']);

            $totalLabaRugiBruto = $pendapatanBersih - $categoryList['BEBAN POKOK PENDAPATAN'];
            $responseFinal[] = $this->accountObj("LABA RUGI (BRUTO)", $totalLabaRugiBruto, $this->calcPercentage($totalLabaRugiBruto, $pendapatanBersih));

            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN USAHA PERUSAHAAN']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN PENJUALAN DAN PEMASARAN']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN OPERASI PERUSAHAAN']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN GAJI']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN UTILITAS']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN OPERASI LAINNYA']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN PEMELIHARAAN']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN ADMINISTRASI']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN PENYUSUTAN']);

            $sumTotalBebanUsaha = $categoryList['BEBAN GAJI'] + $categoryList['BEBAN UTILITAS'] + $categoryList['BEBAN OPERASI LAINNYA'] + $categoryList['BEBAN PEMELIHARAAN']
            + $categoryList['BEBAN ADMINISTRASI'] + $categoryList['BEBAN PENYUSUTAN'] + (count($resultResp['BEBAN PENJUALAN DAN PEMASARAN']) > 0 ? $resultResp['BEBAN PENJUALAN DAN PEMASARAN'][key($resultResp['BEBAN PENJUALAN DAN PEMASARAN'])]['balance'] : 0);
            $totalLabaRugiOperasional = $totalLabaRugiBruto - $sumTotalBebanUsaha;
            $responseFinal[] = $this->accountObj("TOTAL BEBAN OPERASIONAL PERUSAHAAN", $sumTotalBebanUsaha, $this->calcPercentage($sumTotalBebanUsaha, $pendapatanBersih));
            $responseFinal[] = $this->accountObj("LABA RUGI OPERASIONAL", $totalLabaRugiOperasional, $this->calcPercentage($totalLabaRugiOperasional, $pendapatanBersih));

            $responseFinal = array_merge($responseFinal, $resultResp['PENDAPATAN DILUAR USAHA']);
            $responseFinal = array_merge($responseFinal, $resultResp['BEBAN DILUAR USAHA']);

            $totalBebanPendapatanDiluarUsaha = $categoryList['BEBAN DILUAR USAHA'] - $categoryList['PENDAPATAN DILUAR USAHA'];
            $responseFinal[] = $this->accountObj("TOTAL BEBAN (PENDAPATAN) DILUAR USAHA", $totalBebanPendapatanDiluarUsaha, $this->calcPercentage($totalBebanPendapatanDiluarUsaha, $pendapatanBersih));

            $labaRugiSebelumPajak = $totalLabaRugiOperasional - $totalBebanPendapatanDiluarUsaha;
            $responseFinal[] = $this->accountObj("LABA RUGI SEBELUM PAJAK", $labaRugiSebelumPajak, $this->calcPercentage($labaRugiSebelumPajak, $pendapatanBersih));

            $responseFinal = array_merge($responseFinal, $resultResp['PAJAK PENGHASILAN']);

            $totalLabaRugiSetelahPajak = $labaRugiSebelumPajak - $categoryList['PAJAK PENGHASILAN'];
            $responseFinal[] = $this->accountObj("LABA RUGI SETELAH PAJAK", $totalLabaRugiSetelahPajak, $this->calcPercentage($totalLabaRugiSetelahPajak, $pendapatanBersih));

            if ($isTotal) {
                return resultFunction("", true, $totalLabaRugiSetelahPajak);
            }
            return resultFunction("", true, $responseFinal);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-HFP: catch " . $e->getMessage());
        }
    }

    public function accountObj($label, $balance, $percentage) {
        return [
            "name" => $label,
            "category_code" =>  null,
            "coa_id" =>  0,
            "parent_id" =>  null,
            "account_name" =>  null,
            "account_code" =>  "0",
            "balance" =>  $balance,
            "posting_id" =>  5,
            "posting_name" =>  0,
            "first_category" =>  true,
            "is_summary" => true,
            "percentage" => $percentage
        ];
    }

    public function cashflow($data, $companyId) {
        try {
            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT cash.id AS cash_id, cash.is_negative AS is_negative, cash.name AS cash_name,cash.label AS cash_label, ji.balance as balance FROM cashflows as cash
                LEFT JOIN (
                    SELECT cashflow_id,sum(debit) - SUM(credit) AS balance FROM journal_items 
                    WHERE company_id = " . $companyId . " AND YEAR(transaction_date) = " . $data['year'] . " AND MONTH(transaction_date) = " . $data['month'] . "
                    AND deleted_at IS NULL AND approved_at IS NOT NULL
                    GROUP by cashflow_id
                ) AS ji ON ji.cashflow_id = cash.id
            ";
            $queryData = DB::SELECT($query);

            $r = [];
            foreach ($queryData as $x) {
                $check = collect($r)->where('cash_label', $x->cash_label)->first();
                if ($check === null) {
                    $r[] = [
                        "cash_label" => $x->cash_label,
                        "children" => []
                    ];
                }
            }

            $result = [];
            foreach ($r as $x) {
                $childrenF = [];
                $find = collect($queryData)->where('cash_label', $x['cash_label']);
                foreach ($find as $key => $f) {
                    $childrenF[] = $f;
                }
                $find = json_decode(json_encode($childrenF), true);
                $balance = 0;
                foreach ($find as $keyF => $aD) {
                    if ($aD['is_negative']) {
                        $find[$keyF]['balance'] = -1 * ($aD['balance'] === null ? 0 : $aD['balance']);
                    } else {
                        $find[$keyF]['balance'] = ($aD['balance'] === null ? 0 : $aD['balance']);
                    }
                    $balance = $balance + ($find[$keyF]['balance'] === null ? 0 : $find[$keyF]['balance']);
                }

                $x['children'] = $find;
                $x['total_balance'] = $balance;
                $result[] = $x;
            }

            $operasi = collect($result)->where('cash_label', 'ARUS KAS DARI AKTIVITAS OPERASI')->first();
            $investasi = collect($result)->where('cash_label', 'ARUS KAS DARI AKTIVITAS INVESTASI')->first();
            $pendanaan = collect($result)->where('cash_label', 'ARUS KAS DARI AKTIVITAS PENDANAAN')->first();

            return resultFunction("", true, [
                $operasi, $investasi, $pendanaan
            ]);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function cashflowInitial($data, $companyId) {
        try {
            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT c.id,SUM(ji.balance) AS balance FROM coa_categories AS c
                LEFT JOIN coas AS cs ON cs.category_id = c.id AND cs.company_id = " . $companyId . "
                LEFT JOIN (
                    SELECT account_id,description,SUM(debit)-SUM(credit) AS balance
                    FROM journal_items
                    WHERE is_first_balance = 1
                    AND YEAR(transaction_date) = '" . $data['year'] . "'
                    AND deleted_at IS NULL
                    GROUP BY account_id
                )  AS ji ON cs.id = ji.account_id
                WHERE c.name IN ('KAS DAN SETARA KAS', 'KAS', 'BANK')
                LIMIT 1
            ";
            $queryData = DB::SELECT($query);
            $balance = 0;
            if (count($queryData) > 0) {
                if ($queryData[0]->balance !== null) {
                    $balance = $queryData[0]->balance;
                }
            }
            return resultFunction("", true, $balance);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function journal($data, $companyId) {
        try {
            $where = '';
            if (isset($data['status'])) {
                if ($data['status']) {
                    if ($data['status'] === 'approved') {
                        $where = " AND j.approved_at IS NOT NULL AND j.rejected_at IS NULL AND j.deleted_at IS NULL ";
                    } else if ($data['status'] === 'rejected') {
                        $where = " AND j.approved_at IS NULL AND j.rejected_at IS NOT NULL AND j.deleted_at IS NULL ";
                    } else {
                        $where = " AND j.deleted_at is null";
                    }
                } else {
                    $where = " AND j.deleted_at is null";
                }
            }

            if ($data['start_date'] AND $data['end_date']) {
                $where = $where . "  AND j.transaction_date  BETWEEN '" . $data['start_date'] . " 00:00:00' AND '" . $data['end_date'] . " 23:59:59' ";
            }

            if ($where === "") {
                return resultFunction("", true, []);
            }

            $limit = " LIMIT 10000";

            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT j.*,item.debit, item.credit FROM journals as j
                LEFT JOIN 
                (SELECT journal_id, SUM(debit) as debit, SUM(credit) as credit  FROM journal_items WHERE deleted_at IS NULL 
                GROUP BY journal_id) as item ON item.journal_id = j.id
                WHERE j.company_id = " . $companyId . "
                " . $where . "
                ORDER BY j.transaction_date ASC
                " . $limit . "
            ";
            $queryData = DB::SELECT($query);
            return resultFunction("", true, $queryData);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }

    public function generalLedger($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "start_date" => "required",
                "end_date" => "required",
                "data_type" => "required",
                "status" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code JR-GL: " . collect($validator->errors()->all())->implode(" , "));

            $where = '';
            
            if ($data['data_type'] === 1) {
                $where = "  AND ji.is_first_balance = " . $data['data_type'];
            } else if ($data['data_type'] === 0) {
                $where = "  AND ji.is_first_balance = " . $data['data_type'] . "  AND ji.transaction_date  BETWEEN '" . $data['start_date'] . " 00:00:00' AND '" . $data['end_date'] . " 23:59:59'";
            }

            $limit = " LIMIT 10000";

            if ($data['status'] === 'approved') {
                $where = $where . "  AND ji.approved_at IS NOT NULL";
            } else if ($data['status'] === 'rejected') {
                $where = $where . "  AND ji.rejected_at IS NOT NULL";
            }
            $i = 0;

            DB::connection('mysql')->select('SET sql_mode = "";');
            $query = "
                SELECT jn.title,jn.transaction_uid AS uid, jn.approved_at AS approved, categ.name,ca.account_code,ca.account_type, cf.name AS cf_name, ji.*
                FROM journal_items AS ji
                LEFT JOIN coas AS ca ON ca.id = ji.account_id
                LEFT JOIN journals AS jn ON jn.id = ji.journal_id
                LEFT JOIN coa_categories AS categ ON categ.id = ca.category_id
                LEFT JOIN cashflows AS cf ON cf.id = ji.cashflow_id
                WHERE ji.deleted_at IS NULL AND ji.company_id = " . $companyId . "
                " . $where . "
                ORDER BY ji.transaction_date ASC
                " . $limit . "
            ";
            $queryData = DB::SELECT($query);
            return resultFunction("", true, $queryData);
        } catch (\Exception $e) {
            return resultFunction("Err code JR-D: catch " . $e->getMessage());
        }
    }
}