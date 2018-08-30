<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('todos')->insert([
            'user_id' => '1',
            'description' => 'Ongoing Todo',
            'status' => 'U',
            'visibility' => '1',
            'added_on' => date("Y-m-d H:i:s")
        ]);
        
        DB::table('todos')->insert([
            'user_id' => '1',
            'description' => 'Finished Todo',
            'status' => 'F',
            'visibility' => '1',
            'added_on' => date("Y-m-d H:i:s"),
            'finished' => date("Y-m-d H:i:s")
        ]);

        DB::table('todos')->insert([
            'user_id' => '1',
            'description' => 'Removed Todo',
            'status' => 'U',
            'visibility' => '0',
            'added_on' => date("Y-m-d H:i:s")
        ]);
    }
}
