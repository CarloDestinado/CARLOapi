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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->date('record_date');
            $table->enum('record_type', ['consultation', 'lab_result', 'imaging', 'procedure', 'note']);
            $table->string('title');
            $table->text('description');
            $table->text('findings')->nullable();
            $table->boolean('is_confidential')->default(false);
            $table->timestamps();
        });

        Schema::create('diagnosis_medical_record', function (Blueprint $table) {
            $table->foreignId('diagnosis_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->primary(['diagnosis_id', 'medical_record_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosis_medical_record');
        Schema::dropIfExists('medical_records');
    }
};