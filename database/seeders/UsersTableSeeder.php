<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create organization
        $org = Organization::create([
            'name' => 'Oarizon',
            'email' => 'info@oarizon.net',
            'installation_date' => '2020-07-04',
            'licensed' => 100,
        ]);

        // Create currency
        $cur = Currency::create([
            'name' => 'Kenyan Shilling',
            'shortname' => 'KES',
            'organization_id' => $org->id,
        ]);

        // Create user with the correct organization_id
        $user = User::create([
            'name' => 'Ian Wanyoike',
            'email' => 'ian.n.wanyoike@gmail.com',
            'password' => Hash::make('work_work'),
            'organization_id' => $org->id, // Use the created organization's ID
        ]);

        // Create role and sync permissions
        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id')->all(); // Simplified pluck
        $role->syncPermissions($permissions);

        // Assign role to user
        $user->assignRole('Admin');
    }
}