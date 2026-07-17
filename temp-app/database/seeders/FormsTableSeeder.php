<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('forms')->delete();
        
        \DB::table('forms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'book_id' => 2,
                'title' => 'Form C1-040 VISITOR PRE-BOARDING APPROVAL',
                'category' => NULL,
            'file_path' => '1783533960_Form C1-040 VISITOR PRE-BOARDING APPROVAL (1).docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:06:00',
                'updated_at' => '2026-07-08 18:06:00',
            ),
            1 => 
            array (
                'id' => 2,
                'book_id' => 2,
                'title' => 'Form H-023 NAVIGATION IN RESTRICTED VISIBILITY',
                'category' => NULL,
            'file_path' => '1783534013_Form H-023 NAVIGATION IN RESTRICTED VISIBILITY (1).docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:06:53',
                'updated_at' => '2026-07-08 18:06:53',
            ),
            2 => 
            array (
                'id' => 3,
                'book_id' => 2,
                'title' => 'Form H-024 NAVIGATION IN ICE',
                'category' => NULL,
            'file_path' => '1783534029_Form H-024 NAVIGATION IN ICE (1).docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:07:09',
                'updated_at' => '2026-07-08 18:07:09',
            ),
            3 => 
            array (
                'id' => 4,
                'book_id' => 2,
                'title' => 'Form H-025 HEAVY WEATHER NAVIGATION CHECKLIST',
                'category' => NULL,
            'file_path' => '1783534042_Form H-025 HEAVY WEATHER NAVIGATION CHECKLIST (1).docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:07:22',
                'updated_at' => '2026-07-08 18:07:22',
            ),
            4 => 
            array (
                'id' => 5,
                'book_id' => 2,
                'title' => 'Form H-026 DAILY NAVIGATION EQUIPMENT TESTS & CHECKS',
                'category' => NULL,
            'file_path' => '1783534055_Form H-026 DAILY NAVIGATION EQUIPMENT TESTS & CHECKS (1).docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:07:35',
                'updated_at' => '2026-07-08 18:07:35',
            ),
            5 => 
            array (
                'id' => 6,
                'book_id' => 2,
                'title' => 'Form J-017 SAFETY OFFICER INSPECTION CHECKLIST',
                'category' => NULL,
                'file_path' => '1783534069_Form J-017 SAFETY OFFICER INSPECTION CHECKLIST.docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:07:49',
                'updated_at' => '2026-07-08 18:07:49',
            ),
            6 => 
            array (
                'id' => 7,
                'book_id' => 2,
                'title' => 'Review_and_Feedback_Form_Safety_Bulletin_Circular',
                'category' => NULL,
                'file_path' => '1783534080_Review_and_Feedback_Form_Safety_Bulletin_Circular.docx',
                'file_type' => 'word',
                'created_at' => '2026-07-08 18:08:00',
                'updated_at' => '2026-07-08 18:08:00',
            ),
        ));
        
        
    }
}