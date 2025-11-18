<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InspectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['inspections'] as $inspections) {
            Inspections::create([
                'api_id' => $inspections['id'],
                'case_id' => $inspections['case_id'],
                'type' => $inspections['type'],
                'requested_by' => $inspections['requested_by'],
                'start_ts' => $inspections['start_ts'],
                'location' => $inspections['location'],
                'checks' => json_encode($inspections['checks']),
                'assigned_to' => $inspections['assigned_to'],
            ]);
        }
    }
}
