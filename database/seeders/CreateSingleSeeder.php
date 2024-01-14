<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use Illuminate\Database\Seeder;

class CreateSingleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $appId = 2; // Change to current id of apps table
        $nameOfCompany = 'Company'.$appId; // Change to the name of company

        \App\Models\App::create([
            "id" => $appId,
            "domain" => null, // Change to domain if the company wants to have own url
            "is_multiple_company" => 0,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ]);

        $users = json_decode('[{"id":1,"app_id":1,"name":"staff administrator single","email":"staff+administrator+single' . $appId . '@gmail.com","password":"$2y$10$r/BxNgWRGLKrMbCrRDVvU.yGLciUzNEcpytxnFZhaCs9BHtCm4nta","email_verified_at":null,"role_id":"1","created_at":"2023-11-12T06:00:00.000000Z","updated_at":"2023-11-12T06:00:00.000000Z"},{"id":2,"app_id":1,"name":"staff tax single","email":"staff+tax+single' . $appId . '@gmail.com","email_verified_at":null,"role_id":"4","password":"$2y$10$r/BxNgWRGLKrMbCrRDVvU.yGLciUzNEcpytxnFZhaCs9BHtCm4nta","created_at":"2023-11-12T06:00:00.000000Z","updated_at":"2023-11-22T23:19:05.000000Z"},{"id":3,"app_id":1,"name":"staff accounting single","email":"staff+accounting+single' . $appId . '@gmail.com","email_verified_at":null,"password":"$2y$10$r/BxNgWRGLKrMbCrRDVvU.yGLciUzNEcpytxnFZhaCs9BHtCm4nta","role_id":"5","created_at":"2023-11-13T00:42:20.000000Z","updated_at":"2023-11-13T01:50:39.000000Z"},{"id":4,"app_id":1,"name":"staff finance single","email":"staff+finance+single' . $appId . '@gmail.com","email_verified_at":null,"role_id":"3","password":"$2y$10$r/BxNgWRGLKrMbCrRDVvU.yGLciUzNEcpytxnFZhaCs9BHtCm4nta","created_at":"2023-11-13T00:42:20.000000Z","updated_at":"2023-11-13T01:50:39.000000Z"},{"id":5,"app_id":1,"name":"staff admin single","email":"staff+admin+single' . $appId . '@gmail.com","email_verified_at":null,"password":"$2y$10$r/BxNgWRGLKrMbCrRDVvU.yGLciUzNEcpytxnFZhaCs9BHtCm4nta","role_id":"2","created_at":"2023-11-12T06:00:00.000000Z","updated_at":"2023-11-12T06:00:00.000000Z"}]', true);
        foreach ($users as $user) {
            $user['id'] = null;
            $user['app_id'] = $appId;
            \App\Models\User::create($user);
        }

        $company = new Company();
        $company->app_id = $appId;
        $company->title = $nameOfCompany;
        $company->type = 'pt';
        $company->voucher_prefix = 'CS' . $appId;
        $company->is_locked = 1;
        $company->save();

        (new CompanyRepository())->createDefaultCompany($company);

    }
}
