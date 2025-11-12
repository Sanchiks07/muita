<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Http\Controllers\CasesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\InspectionsController;
use App\Http\Controllers\PartiesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiclesController;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        (new CasesController())->index();
        (new DocumentsController())->index();
        (new InspectionsController())->index();
        (new PartiesController())->index();
        (new UserController())->index();
        (new VehiclesController())->index();
    }
}
