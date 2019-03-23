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
        $records = [];

        $roles = [
            'manager',
            'developer'
        ];

        foreach ($roles as $key => $value) {
            $record = [
                'name' => $value,
            ];

            $records[] = $record;
        }

        DB::table('roles')->insert($records);
    }
}
