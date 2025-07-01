<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Organization::create([
            'name' => 'Acme Corporation',
            'email' => 'info@acme.com',
            'address' => '123 Main Street, Cityville',
            'phone' => '123-456-7890',
            'annual_support_key' => 'ACME-2025-001',
        ]);

        \App\Models\Organization::create([
            'name' => 'Globex Inc.',
            'email' => 'contact@globex.com',
            'address' => '456 Elm Avenue, Townsville',
            'phone' => '987-654-3210',
            'annual_support_key' => 'GLOBEX-2025-002',
        ]);
    }
}
