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
        Schema::table('provider_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('provider_id')->after('folder_id')->nullable();
            $table->unsignedBigInteger('doctor_id')->after('provider_id')->nullable();
            $table->unsignedBigInteger('patient_id')->after('doctor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_documents', function (Blueprint $table) {
            $table->dropColumn(['provider_id', 'doctor_id', 'patient_id']);
        });
    }
};
