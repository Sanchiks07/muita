<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
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
                'plate_no' => $inspections['plate_no'],
                'country' => $inspections['country'],
                'make' => $inspections['make'],
                'model' => $inspections['model'],
                'vin' => $inspections['vin'],
            ]);
        }
    }
}
