<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartiesSeeder extends Seeder
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
                'type' => $inspections['type'],
                'name' => $inspections['name'],
                'reg_code' => $inspections['reg_code'],
                'vat' => $inspections['vat'],
                'country' => $inspections['country'],
                'email' => json_encode($inspections['email']),
                'phone' => $inspections['phone'],
            ]);
        }
    }
}
