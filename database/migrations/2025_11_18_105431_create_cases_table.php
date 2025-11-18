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
            $table->string('api_id')->unique();
            $table->string('external_ref');
            $table->string('status');
            $table->string('priority');
            $table->string('arrival_ts');
            $table->string('checkpoint_ts');
            $table->string('origin_country');
            $table->string('destination_country');
            $table->string('risk_flags')->nullable();
            $table->string('declarant_id');
            $table->foreign('declarant_id')->references('api_id')->on('parties');
            $table->string('consignee_id');
            $table->foreign('consignee_id')->references('api_id')->on('parties');
            $table->string('vehicle_id');
            $table->foreign('vehicle_id')->references('api_id')->on('vehicles');
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
