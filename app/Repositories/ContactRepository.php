<?php

namespace App\Repositories;

use App\Models\Coa;
use App\Models\Contact;

class ContactRepository {

    public function store($data, $companyId) {
        try {

            $validator = \Validator::make($data, [
                "name" => 'required',
            ]);

            if ($validator->fails()) return resultFunction("Err code CR-S: " . collect($validator->errors()->all())->implode(" , "));

            $message = "Creating";
            if ($data['id']) {
                $contact = Contact::find($data['id']);
                if (!$contact) return resultFunction("Err code CR-S: contact not found for ID " . $data['id']);
                $message = 'Updating';
            } else {
                $contact = new Contact();
                $contact->company_id = $companyId;
                if (isset($data['type'])) {
                    if ($data['type'] === 'customer') {
                        $coaSale = Coa::with([])->where('account_number', 100001)->where('company_id', $companyId)->first();
                        $data['sale_account_id'] = $coaSale->id;
                    } elseif ($data['type'] === 'vendor') {
                        $coaSale = Coa::with([])->where('account_number', 200001)->where('company_id', $companyId)->first();
                        $data['purchase_account_id'] = $coaSale->id;
                    }
                }
            }
            $contact->sale_account_id = $data['sale_account_id'];
            $contact->purchase_account_id = $data['purchase_account_id'];
            $contact->name = $data['name'];
            $contact->email = $data['email'];
            $contact->phone = $data['phone'];
            $contact->identity_number = $data['identity_number'];
            $contact->npwp_number = $data['npwp_number'];
            $contact->address = $data['address'];
            $contact->sale_account_id = $data['sale_account_id'];
            $contact->purchase_account_id = $data['purchase_account_id'];
            $contact->save();

            return resultFunction($message . " contact is successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-S: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $contact = Contact::find($id);
            if (!$contact) return resultFunction("Err code CR-D: contact not found");

            return resultFunction("", true, $contact);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-D: catch " . $e->getMessage());
        }
    }

    public function archive($id) {
        try {
            $contact = Contact::find($id);
            if (!$contact) return resultFunction("Err code CR-D: contact not found");

            $contact->is_archive = !$contact->is_archive;
            $contact->save();
            return resultFunction("", true, $contact);
        } catch (\Exception $e) {
            return resultFunction("Err code CR-D: catch " . $e->getMessage());
        }
    }
}