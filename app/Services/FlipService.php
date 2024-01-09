<?php

namespace App\Services;

class FlipService {
    protected $flipKey;

    public function __construct($flipKey)
    {
        $this->flipKey = $flipKey;
    }

    public function checkInquiry($payloads = [], $idempotencyKey = "") {
        try {
            $url = 'disbursement/bank-account-inquiry';
            return $this->_callPost($url, $payloads);
        } catch (\Exception $e) {
            return resultFunction("Err code FS-CI: catch " . $e->getMessage());
        }
    }

    private function _callPost($url, $payloads = [], $idempotencyKey = "") {
        try {
            $ch = curl_init();

            $headers[]      = "Content-Type: application/x-www-form-urlencoded";
            if($idempotencyKey){
                $headers[]  = "idempotency-key: " . $idempotencyKey;
            }
            $url = env('FLIP_ENDPOINT', null) . $url;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERPWD, $this->flipKey . ":");
            $response = json_decode(curl_exec($ch));

            if (curl_error($ch)) {
                $error_msg = curl_error($ch);
            }
            curl_close($ch);
            if(!empty($response->name)){
                if($response->name == 'Unauthorized'){
                    return resultFunction("401 Unauthorized, please make sure a valid flip key", false, $response);
                }

                if($response->name == 'Not Found'){
                    return resultFunction("404 Not Found", false, $response);
                }
                return resultFunction("no message received", false, $response);
            }
            return resultFunction("", true, $response);
        } catch (\Exception $e) {
            return resultFunction("Err code FS-CI: catch " . $e->getMessage());
        }
    }

    public function pushToFlip($transaction) {
        try {
            $payloads = [
                "account_number" => $transaction->account_number,
                "bank_code" => $transaction->bank,
                "amount" => (int) $transaction->dpp,
                "remark" => "test"
            ];
            $url = 'disbursement';
            $idempotencyKey = 'demo-anggaran-' . $transaction->id . '-' . date("His");

            return $this->_callPost($url, $payloads, $idempotencyKey);
        } catch (\Exception $e) {
            return resultFunction("Err code FS-PTF: catch " . $e->getMessage());
        }
    }
}