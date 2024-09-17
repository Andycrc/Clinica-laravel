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
        Schema::create('medical_prescriptions', function (Blueprint $table) {
            $table->id('prescription_id');
            $table->longText('title');
            $table->longText('description');
            $table->unsignedBigInteger('appointment_id');
            $table->timestamps();

            $table->foreign('appointment_id')->references('appointment_id')->on('appointments')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_prescriptions');
    }
};
