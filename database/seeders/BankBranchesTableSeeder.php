<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class BankBranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $branches = [
            ['branch_code' => '001', 'bank_branch_name' => 'KCB Moi Avenue', 'organization_id' => 1, 'bank_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['branch_code' => '002', 'bank_branch_name' => 'Equity Kenyatta Avenue', 'organization_id' => 1, 'bank_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['branch_code' => '003', 'bank_branch_name' => 'Co-op Bank Haile Selassie', 'organization_id' => 1, 'bank_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['branch_code' => '004', 'bank_branch_name' => 'Absa Westlands', 'organization_id' => 1, 'bank_id' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['branch_code' => '005', 'bank_branch_name' => 'NCBA Junction', 'organization_id' => 1, 'bank_id' => 5, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('bank_branches')->insert($branches);
    }
}
