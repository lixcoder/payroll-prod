<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class BanksTableSeeder extends Seeder
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
            ['bank_name' => 'Kenya Commercial Bank', 'bank_code' => '01', 'organization_id' => 1 , 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Equity Bank', 'bank_code' => '02', 'organization_id' => 1 , 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Co-operative Bank', 'bank_code' => '03', 'organization_id' => 1 , 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'Absa Bank Kenya', 'bank_code' => '04', 'organization_id' => 1 , 'created_at' => $now, 'updated_at' => $now],
            ['bank_name' => 'NCBA Bank', 'bank_code' => '05', 'organization_id' => 1 , 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('banks')->insert($banks);
    }
}
