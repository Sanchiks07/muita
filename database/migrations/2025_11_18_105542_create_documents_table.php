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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('api_id')->unique();
            $table->string('case_id');
            $table->foreign('case_id')->references('api_id')->on('cases');
            $table->string('filename');
            $table->string('mime_type');
            $table->string('category');
            $table->integer('pages');
            $table->string('uploaded_by');
            $table->foreign('uploaded_by')->references('username')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
