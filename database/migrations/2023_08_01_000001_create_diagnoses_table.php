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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->string('icd_code')->comment('ICD-10/11 code');
            $table->string('diagnosis_name');
            $table->text('description')->nullable();
            $table->date('diagnosis_date');
            $table->enum('status', ['active', 'chronic', 'resolved'])->default('active');
            $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable();
            $table->text('treatment_plan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};