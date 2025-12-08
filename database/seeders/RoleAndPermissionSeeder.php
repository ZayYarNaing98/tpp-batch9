<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        $client = Role::create(['name' => 'Client']);

        $dashboard = Permission::create(['name' => 'dashboard']);

        $categoryList = Permission::create(['name' => 'categoryList']);
        $categoryCreate = Permission::create(['name' => 'categoryCreate']);
        $categoryUpdate = Permission::create(['name' => 'categoryUpdate']);
        $categoryDelete = Permission::create(['name' => 'categoryDelete']);

        $productList = Permission::create(['name' => 'productList']);
        $productCreate = Permission::create(['name' => 'productCreate']);
        $productUpdate = Permission::create(['name' => 'productUpdate']);
        $productDelete = Permission::create(['name' => 'productDelete']);

        $admin->givePermissionTo([
            $dashboard,

            $categoryList,
            $categoryCreate,
            $categoryUpdate,
            $categoryDelete,

            $productList,
            $productCreate,
            $productUpdate,
            $productDelete,
        ]);

        $client->givePermissionTo([
            $categoryList,

            $productList,
        ]);
    }
}
