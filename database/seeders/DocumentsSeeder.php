<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['documents'] as $documents) {
            Documents::create([
                'api_id' => $documents['id'],
                'case_id' => $documents['case_id'],
                'filename' => $documents['filename'],
                'mime_type' => $documents['mime_type'],
                'category' => $documents['category'],
                'pages' => $documents['pages'],
                'uploaded_by' => $documents['uploaded_by'],
            ]);
        }
    }
}
