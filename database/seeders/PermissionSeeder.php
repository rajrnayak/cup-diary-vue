<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // dashboard -----------------------------------------------------------
            [
                "name" => 'admin_dashboard',
                'guard_name' => 'web',
                "display_name" => 'Admin Dashboard',
                "category" => 'dashboard',
            ],

            // user ----------------------------------------------------------------
            [
                "name" => 'user_view',
                'guard_name' => 'web',
                "display_name" => 'User View',
                "category" => 'user',
            ],
            [
                "name" => 'user_store',
                'guard_name' => 'web',
                "display_name" => 'User Store',
                "category" => 'user',
            ],
            [
                "name" => 'user_update',
                'guard_name' => 'web',
                "display_name" => 'User Update',
                "category" => 'user',
            ],
            [
                "name" => 'user_delete',
                'guard_name' => 'web',
                "display_name" => 'User Delete',
                "category" => 'user',
            ],

            // vendor ---------------------------------------------------------------
            [
                "name" => 'vendor_view',
                'guard_name' => 'web',
                "display_name" => 'Vendor View',
                "category" => 'vendor',
            ],

            // cup-list ---------------------------------------------------------------
            [
                "name" => 'cupList_view',
                'guard_name' => 'web',
                "display_name" => 'CupList View',
                "category" => 'cupList',
            ],

            // role -----------------------------------------------------------------
            [
                "name" => 'role_view',
                'guard_name' => 'web',
                "display_name" => 'Role View',
                "category" => 'role',
            ],


            // payment --------------------------------------------------------------
            [
                "name" => 'payment_view',
                'guard_name' => 'web',
                "display_name" => 'Payment View',
                "category" => 'payment',
            ],
        ];

        Permission::insert($permissions);

        $adminRole = Role::where('name','admin')->first();
        $userRole = Role::where('name','user')->first();

        $adminRole->givePermissionTo([
            'admin_dashboard','user_view','vendor_view'
        ]);

        $userRole->givePermissionTo([
            'admin_dashboard','vendor_view'
        ]);
    }
}
