<?php

namespace App\Http\Controllers;

use App\Repositories\JournalRepository;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AppController extends Controller
{
    public function index()
    {
        return view('app');
    }

    public function printBalanceSheet(Request $request) {
        $filters = $request->only(['company_id']);
        $months = ["01" => "January", "02" =>  "February", "03" => "March", "04" => "April", "05" => 'May', "06" => "June", "07" => "July", "08" => "August",
            "09" => "September", "10" => "October", "11" => "November", "12" => "December"];
        $journalRepo = new JournalRepository();
        $resp = [];
        foreach ($months as $key => $month) {
            $resp[$key] = $journalRepo->balanceProfit([
                'month' => $key,
                'year' => '2023',
                'type' => 'balance_sheet'
            ], $filters['company_id']);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $fileName = 'export-balance-sheet-'.date('Y-m-d H:i:s');
        $headerStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        $blockStyle = [
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'BFBF3F',
                ],
                'endColor' => [
                    'argb' => 'BFBF3F',
                ],
            ],
            'font' => [
                'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];

        $fillStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);

        $sheet->setCellValue('A1', 'Account')->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->setCellValue('B1', 'January')->getStyle('B1')->applyFromArray($headerStyle);
        $sheet->setCellValue('C1', 'February')->getStyle('C1')->applyFromArray($headerStyle);
        $sheet->setCellValue('D1', 'March')->getStyle('D1')->applyFromArray($headerStyle);
        $sheet->setCellValue('E1', 'April')->getStyle('E1')->applyFromArray($headerStyle);
        $sheet->setCellValue('F1', 'May')->getStyle('F1')->applyFromArray($headerStyle);
        $sheet->setCellValue('G1', 'June')->getStyle('G1')->applyFromArray($headerStyle);
        $sheet->setCellValue('H1', 'July')->getStyle('H1')->applyFromArray($headerStyle);
        $sheet->setCellValue('I1', 'August')->getStyle('I1')->applyFromArray($headerStyle);
        $sheet->setCellValue('J1', 'September')->getStyle('J1')->applyFromArray($headerStyle);
        $sheet->setCellValue('K1', 'October')->getStyle('K1')->applyFromArray($headerStyle);
        $sheet->setCellValue('L1', 'November')->getStyle('L1')->applyFromArray($headerStyle);
        $sheet->setCellValue('M1', 'Desember')->getStyle('M1')->applyFromArray($headerStyle);


        $columnAbjad = ["B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M"];
        $num = 2;
        foreach ($resp as $key => $item){
            if ($key != '01') {
                $num = $num - (count($item['data']['accounts'])+count($item['data']['posting']));
            }
            foreach ($item['data']['accounts'] as $account) {
                if ($key == "01") {
                    $sheet->setCellValue('A'.$num, $account["account_name"] ?? $account['name'])
                        ->getStyle('A'.$num)->applyFromArray($account["account_name"] ? $fillStyle : $blockStyle);
                }
                $sheet->setCellValue($columnAbjad[(int) $key - 1].$num, $account['balance'])
                    ->getStyle($columnAbjad[(int) $key - 1].$num)->applyFromArray($account["account_name"] ? $fillStyle : $blockStyle);
                $num++;
            }
            foreach ($item['data']['posting'] as $post) {
                if ($key == "01") {
                    $sheet->setCellValue('A'.$num, $post["account_name"] ?? $post['name'])
                        ->getStyle('A'.$num)->applyFromArray($blockStyle);
                }
                $sheet->setCellValue($columnAbjad[(int) $key - 1].$num, $post['balance'])
                    ->getStyle($columnAbjad[(int) $key - 1].$num)->applyFromArray($blockStyle);
                $num++;
            }
        }


        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'".xlsx"');
        $writer->save("php://output");
        exit;
    }

    public function printProfitLose(Request $request) {
        $filters = $request->only(['company_id']);
        $months = ["01" => "January", "02" =>  "February", "03" => "March", "04" => "April", "05" => 'May', "06" => "June", "07" => "July", "08" => "August",
            "09" => "September", "10" => "October", "11" => "November", "12" => "December"];
        $journalRepo = new JournalRepository();
        $resp = [];
        foreach ($months as $key => $month) {
            $resp[$key] = $journalRepo->balanceProfit([
                'month' => $key,
                'year' => '2023',
                'type' => 'profit_lose'
            ], $filters['company_id']);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $fileName = 'export-profit-lost-'.date('Y-m-d H:i:s');
        $headerStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        $blockStyle = [
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'BFBF3F',
                ],
                'endColor' => [
                    'argb' => 'BFBF3F',
                ],
            ],
            'font' => [
                'name'  => 'Times New Roman',
                'bold'  => true,
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];

        $fillStyle = [
            'font' => [
                'name'  => 'Times New Roman',
                'size'  => 11,
            ],
            'alignment' => [
                'wrapText'  => true,
                'vertical'      => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);
        $sheet->getColumnDimension('R')->setAutoSize(true);
        $sheet->getColumnDimension('S')->setAutoSize(true);
        $sheet->getColumnDimension('T')->setAutoSize(true);
        $sheet->getColumnDimension('U')->setAutoSize(true);
        $sheet->getColumnDimension('V')->setAutoSize(true);
        $sheet->getColumnDimension('W')->setAutoSize(true);
        $sheet->getColumnDimension('X')->setAutoSize(true);
        $sheet->getColumnDimension('Y')->setAutoSize(true);

        $sheet->setCellValue('A1', 'Account')->getStyle('A1')->applyFromArray($headerStyle);
        $sheet->setCellValue('B1', 'January')->getStyle('B1')->applyFromArray($headerStyle);
        $sheet->setCellValue('C1', '%')->getStyle('C1')->applyFromArray($headerStyle);
        $sheet->setCellValue('D1', 'February')->getStyle('D1')->applyFromArray($headerStyle);
        $sheet->setCellValue('E1', '%')->getStyle('E1')->applyFromArray($headerStyle);
        $sheet->setCellValue('F1', 'March')->getStyle('F1')->applyFromArray($headerStyle);
        $sheet->setCellValue('G1', '%')->getStyle('G1')->applyFromArray($headerStyle);
        $sheet->setCellValue('H1', 'April')->getStyle('H1')->applyFromArray($headerStyle);
        $sheet->setCellValue('I1', '%')->getStyle('I1')->applyFromArray($headerStyle);
        $sheet->setCellValue('J1', 'May')->getStyle('J1')->applyFromArray($headerStyle);
        $sheet->setCellValue('K1', '%')->getStyle('K1')->applyFromArray($headerStyle);
        $sheet->setCellValue('L1', 'June')->getStyle('L1')->applyFromArray($headerStyle);
        $sheet->setCellValue('M1', '%')->getStyle('M1')->applyFromArray($headerStyle);
        $sheet->setCellValue('N1', 'July')->getStyle('N1')->applyFromArray($headerStyle);
        $sheet->setCellValue('O1', '%')->getStyle('O1')->applyFromArray($headerStyle);
        $sheet->setCellValue('P1', 'August')->getStyle('P1')->applyFromArray($headerStyle);
        $sheet->setCellValue('Q1', '%')->getStyle('Q1')->applyFromArray($headerStyle);
        $sheet->setCellValue('R1', 'September')->getStyle('R1')->applyFromArray($headerStyle);
        $sheet->setCellValue('S1', '%')->getStyle('S1')->applyFromArray($headerStyle);
        $sheet->setCellValue('T1', 'October')->getStyle('T1')->applyFromArray($headerStyle);
        $sheet->setCellValue('U1', '%')->getStyle('U1')->applyFromArray($headerStyle);
        $sheet->setCellValue('V1', 'November')->getStyle('V1')->applyFromArray($headerStyle);
        $sheet->setCellValue('W1', '%')->getStyle('W1')->applyFromArray($headerStyle);
        $sheet->setCellValue('X1', 'Desember')->getStyle('X1')->applyFromArray($headerStyle);
        $sheet->setCellValue('Y1', '%')->getStyle('Y1')->applyFromArray($headerStyle);


        $columnAbjad = [["B", "C"], ["D", "E"], ["F", "G"], ["H", "I"], ["J", "K"], ["L", "M"], ["N", "O"], ["P", "Q"], ["R", "S"], ["T", "U"], ["V", "W"], ["X", "Y"]];
        $num = 2;
        foreach ($resp as $key => $item){
            if ($key != '01') {
                $num = $num - (count($item['data']['accounts'])+count($item['data']['posting']));
            }
            foreach ($item['data']['accounts'] as $account) {
                if ($key == "01") {
                    $sheet->setCellValue('A'.$num, $account["account_name"] ?? $account['name'])
                        ->getStyle('A'.$num)->applyFromArray($account["account_name"] ? $fillStyle : $blockStyle);
                }
                $sheet->setCellValue($columnAbjad[(int) $key - 1][0].$num, $account['balance'])
                    ->getStyle($columnAbjad[(int) $key - 1][0].$num)->applyFromArray($account["account_name"] ? $fillStyle : $blockStyle);
                $sheet->setCellValue($columnAbjad[(int) $key - 1][1].$num, $account['balance'])
                    ->getStyle($columnAbjad[(int) $key - 1][1].$num)->applyFromArray($account["account_name"] ? $fillStyle : $blockStyle);
                $num++;
            }
        }


        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'".xlsx"');
        $writer->save("php://output");
        exit;
    }
}
