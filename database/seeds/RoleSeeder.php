<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            ['name' => 'manager'],
            ['name' => 'developer']
        ];

        DB::table('roles')->insert($records);
    }
}
