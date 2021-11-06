<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        foreach (app_features() as $key => $app_feature) {
            try {
                Permission::create(['name' => 'create ' . $key]);
            }catch (\Exception $exception) {}
            try {
                Permission::create(['name' => 'read ' . $key]);
            } catch (\Exception $exception) {}
            try {
                Permission::create(['name' => 'edit ' . $key]);

            }catch (\Exception $exception) {}
            try {
                Permission::create(['name' => 'delete ' . $key]);
            } catch (\Exception $exception) {}

        }

    }
}
