<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesProduct;
use Illuminate\Support\Facades\DB;

class SalesRepository {

    public function storeCustomer($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "name" => 'required',
                "phone" => 'required',
                "identity_number" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-SC: " . collect($validator->errors()->all())->implode(" , "));

            $message = "Creating";
            if ($data['id']) {
                $customer = Customer::find($data['id']);
                if (!$customer) return resultFunction("Err code SR-SC: customer not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $customer = new Customer();
                $customer->company_id = $companyId;
            }
            $customer->name = $data['name'];
            $customer->email = $data['email'] ?? null;
            $customer->phone = $data['phone'];
            $customer->identity_number = $data['identity_number'];
            $customer->npwp_number = $data['npwp_number'] ?? null;
            $customer->address = $data['address'] ?? null;
            $customer->save();

            return resultFunction($message . " customer is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-SC: catch " . $e->getMessage());
        }
    }

    public function detailCustomer($id) {
        try {
            $customer = Customer::find($id);
            if (!$customer) return resultFunction("Err code SR-DU: customer not found");

            return resultFunction("", true, $customer);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-DU: catch " . $e->getMessage());
        }
    }

    public function store($data, $companyId) {
        try {
            $validator = \Validator::make($data, [
                "customer" => 'required',
                "invoice_date" => 'required',
                "due_date" => 'required',
                "products" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code SR-S: " . collect($validator->errors()->all())->implode(" , "));

            DB::beginTransaction();

            $customer = Customer::find($data['customer']);
            if (!$customer) return resultFunction("Err code SR-S: customer not found for ID " . $data['customer']);

            $message = "Creating";
            if ($data['id']) {
                $sales = Sales::find($data['id']);
                if (!$sales) return resultFunction("Err code SR-S: sales not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $sales = new Sales();
                $sales->company_id = $companyId;
                $sales->invoice_number = 'DRAFT';
            }
            $sales->customer_id = $customer->id;
            $sales->invoice_date = $data['invoice_date'];
            $sales->due_date = $data['due_date'];
            $sales->amount_total = 0;
            $sales->description = $data['description'] ?? '';
            $sales->save();

            if ($data['id']) {
                SalesProduct::where('sales_id', $sales->id)->delete();
            }

            $products = Product::with([])
                ->whereIn('id', array_column($data['products'], 'product'))
                ->get();

            $salesProductInput = [];
            $amountTotal = 0;
            foreach ($data['products'] as $productInput) {
                $selectProduct = $products->where('id', $productInput['product'])->first();
                if (!$selectProduct) return resultFunction("Err code SR-S: product db is not found");

                $amount = $productInput['quantity'] * $productInput['rate'];
                $salesProductInput[] = [
                    'sales_id' => $sales->id,
                    'product_id' => $selectProduct->id,
                    'quantity' => $productInput['quantity'],
                    'rate' => $productInput['rate'],
                    'amount' => $amount,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $amountTotal = $amountTotal + $amount;
            }
            $sales->amount_total = $amountTotal;
            $sales->save();

            SalesProduct::insert($salesProductInput);

            DB::commit();
            return resultFunction($message . " sales is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code SR-S: catch " . $e->getMessage());
        }
    }
}