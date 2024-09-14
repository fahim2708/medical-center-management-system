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
        if (!Schema::hasTable('provider_documents_folders')) {
        Schema::create('provider_documents_folders', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name');
            $table->foreignId('provider_id')->constrained('providers', 'id')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors', 'id')->onDelete('cascade');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('provider_documents_folders');
    }
};
