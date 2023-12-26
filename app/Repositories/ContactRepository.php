<?php

namespace App\Repositories;

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

            return resultFunction($message . " customer is successfully", true);
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
}