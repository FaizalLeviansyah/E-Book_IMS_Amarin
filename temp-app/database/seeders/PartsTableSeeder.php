<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PartsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('parts')->delete();
        
        \DB::table('parts')->insert(array (
            0 => 
            array (
                'id' => 2,
                'book_id' => 2,
                'title' => 'IMS Latest Update 2025',
                'slug' => 'ims-latest-update-2025',
                'created_at' => '2026-07-07 02:45:25',
                'updated_at' => '2026-07-08 03:56:10',
            ),
        ));
        
        
    }
}