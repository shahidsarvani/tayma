<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            [
                'name' => 'add-role'
            ],
            [
                'name' => 'edit-role'
            ],
            [
                'name' => 'view-role'
            ],
            [
                'name' => 'delete-role'
            ],
            [
                'name' => 'add-permission'
            ],
            [
                'name' => 'edit-permission'
            ],
            [
                'name' => 'view-permission'
            ],
            [
                'name' => 'delete-permission'
            ],
            [
                'name' => 'add-user'
            ],
            [
                'name' => 'edit-user'
            ],
            [
                'name' => 'view-user'
            ],
            [
                'name' => 'delete-user'
            ],
            [
                'name' => 'add-screen'
            ],
            [
                'name' => 'edit-screen'
            ],
            [
                'name' => 'view-screen'
            ],
            [
                'name' => 'delete-screen'
            ],
            [
                'name' => 'add-slide'
            ],
            [
                'name' => 'edit-slide'
            ],
            [
                'name' => 'view-slide'
            ],
            [
                'name' => 'delete-slide'
            ],
            [
                'name' => 'add-card'
            ],
            [
                'name' => 'edit-card'
            ],
            [
                'name' => 'view-card'
            ],
            [
                'name' => 'delete-card'
            ],
            [
                'name' => 'add-touchtable-screen-menu'
            ],
            [
                'name' => 'edit-touchtable-screen-menu'
            ],
            [
                'name' => 'view-touchtable-screen-menu'
            ],
            [
                'name' => 'delete-touchtable-screen-menu'
            ],
            [
                'name' => 'add-touchtable-screen-media'
            ],
            [
                'name' => 'edit-touchtable-screen-media'
            ],
            [
                'name' => 'view-touchtable-screen-media'
            ],
            [
                'name' => 'delete-touchtable-screen-media'
            ],
            [
                'name' => 'add-touchtable-screen-content'
            ],
            [
                'name' => 'edit-touchtable-screen-content'
            ],
            [
                'name' => 'view-touchtable-screen-content'
            ],
            [
                'name' => 'delete-touchtable-screen-content'
            ],
            [
                'name' => 'touchtable-screen'
            ],
            [
                'name' => 'add-portrait-screen-video'
            ],
            [
                'name' => 'edit-portrait-screen-video'
            ],
            [
                'name' => 'view-portrait-screen-video'
            ],
            [
                'name' => 'delete-portrait-screen-video'
            ],
            [
                'name' => 'add-portrait-screen'
            ],
            [
                'name' => 'edit-portrait-screen'
            ],
            [
                'name' => 'view-portrait-screen'
            ],
            [
                'name' => 'delete-portrait-screen'
            ],
            [
                'name' => 'portrait-screen'
            ],
            [
                'name' => 'edit-logo'
            ],
            [
                'name' => 'add-videowall-screen-menu'
            ],
            [
                'name' => 'edit-videowall-screen-menu'
            ],
            [
                'name' => 'view-videowall-screen-menu'
            ],
            [
                'name' => 'delete-videowall-screen-menu'
            ],
            [
                'name' => 'add-videowall-screen-content'
            ],
            [
                'name' => 'edit-videowall-screen-content'
            ],
            [
                'name' => 'view-videowall-screen-content'
            ],
            [
                'name' => 'delete-videowall-screen-content'
            ],
        ];
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        foreach ($permissions as $item) {
            Permission::create($item);
        }
    }
}
