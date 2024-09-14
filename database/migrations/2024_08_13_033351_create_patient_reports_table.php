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
        if (!Schema::hasTable('patient_reports')) {
        Schema::create('patient_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients', 'id')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('providers', 'id')->onDelete('cascade');
            $table->enum('document_type', ['INITIAL', 'FOLLOW-UP', 'POST-OP', 'PRE-OP', 'OPERATIVE REPORT']);
            $table->date('visit_date');
            $table->string('file_name');      
            $table->string('file_path');
            $table->longText('description')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default(2)->comment('1=Aprroved, 2=Pending, 3=Rejected, 4=Fix');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_reports');
    }
};
