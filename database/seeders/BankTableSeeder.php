<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $banks = [
            ['bank_name' => 'Kenya Commercial Bank', 'bank_code' => '01', 'organization_code' => 'KCB', 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Equity Bank', 'bank_code' => '02', 'organization_code' => 'EQB', 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Co-operative Bank', 'bank_code' => '03', 'organization_code' => 'COOP', 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Absa Bank Kenya', 'bank_code' => '04', 'organization_code' => 'ABSA', 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'NCBA Bank', 'bank_code' => '05', 'organization_code' => 'NCBA', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('banks')->insert($banks);
    }
}
