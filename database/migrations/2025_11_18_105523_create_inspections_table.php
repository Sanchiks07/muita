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
            $table->string('api_id')->unique();
            $table->string('case_id');
            $table->foreign('case_id')->references('api_id')->on('cases');
            $table->string('type');
            $table->string('requested_by');
            $table->string('start_ts');
            $table->string('location');
            $table->string('checks');
            $table->string('assigned_to');
            $table->foreign('assigned_to')->references('username')->on('users');
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
