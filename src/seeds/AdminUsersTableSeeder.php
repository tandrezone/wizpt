<?php
namespace wizpt\cms\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->insert([
            'name' => 'Developers wiz',
            'email' => 'developers@wiz.pt',
            'password' => bcrypt('wiz'),
            'role_id' => 1,
        ]);
    }
}
