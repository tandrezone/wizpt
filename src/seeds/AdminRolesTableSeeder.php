<?php
namespace wizpt\cms\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_roles')->insert([
            'id' => 1,
            'name' => 'Administrator',
        ]);
        DB::table('admin_roles')->insert([
            'id' => 2,
            'name' => 'Moderator',
        ]);
        DB::table('admin_roles')->insert([
            'id' => 3,
            'name' => 'User',
        ]);
    }
}
