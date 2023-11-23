<?php

namespace App\Imports;

use App\Models\Coa;
use App\Models\PackingReceipt;
use Maatwebsite\Excel\Concerns\ToModel;

class CoaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Coa([
            'Category' => $row[0],
            'Posting' => $row[1],
            'Account Number' => $row[2],
            'Account Name' => $row[3],
            'Account Type' => $row[4],
        ]);
    }
}
