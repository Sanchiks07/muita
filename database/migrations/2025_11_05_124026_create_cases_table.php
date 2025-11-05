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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('id');
            $table->string('external_ref');
            $table->string('status');
            $table->string('priority');
            // $table->string('arrival_ts'); - uataisi lai šis der kā timestamp
            $table->string('checkpoint_id');
            $table->string('origin_country');
            $table->string('destination_country');
            $table->json('risk_flags');
            $table->foreign('declarant_id')->refrences('id')->on('parties');
            $table->foreign('consignee_id')->refrences('id')->on('parties');
            $table->foreign('vehicle_id')->refrences('id')->on('vehicles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
