<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muitaData = Http::withoutVerifying()->get('https://deskplan.lv/muita/app.json')->json();

        foreach ($muitaData['users'] as $users) {
            User::create([
                'api_id' => $users['id'],
                'username' => $users['username'],
                'full_name' => $users['full_name'],
                'role' => $users['role'],
                'active' => $users['active'],
                'password' => 'password123',
            ]);
        }
    }
}
