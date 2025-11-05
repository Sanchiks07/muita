<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->string('id');
            $table->foreign('case_id')->refrences('id')->on('cases');
            $table->string('type');
            $table->string('requested_by');
            // $table->string('start_ts'); - uataisi lai šis der kā timestamp
            $table->string('location');
            $table->foreign('plate_no')-refrencees('plate_no')->on('vehicles');
            // $table->string(''); - uztaisi lai "checks", lai ir array
            $table->foreign('assigned_to')->refrences('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
