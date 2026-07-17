<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('books')->delete();
        
        \DB::table('books')->insert(array (
            0 => 
            array (
                'id' => 2,
            'title' => 'Integrated Management System (IMS)',
                'slug' => 'integrated-management-system-ims',
                'description' => 'Manual Keselamatan & Operasional PT Amarin Ship Management',
                'theme_color' => '#0d47a1',
                'cover_image' => '1783392309_cover.png',
                'pdf_file' => NULL,
                'created_at' => '2026-07-07 02:45:10',
                'updated_at' => '2026-07-07 02:45:10',
            ),
        ));
        
        
    }
}