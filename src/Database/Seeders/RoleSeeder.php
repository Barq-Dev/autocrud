<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = ['users'];
        
        $features = ['manage','view','create','edit','delete','restore','export'];
        
        foreach ($modules as $module)
            foreach ($features as $feature)
                Permission::firstOrCreate(['name'=>"$module-$feature"]);
    }
}
