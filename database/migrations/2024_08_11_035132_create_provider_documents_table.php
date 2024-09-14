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
        if (!Schema::hasTable('provider_documents')) {
        Schema::create('provider_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('provider_documents_folders', 'id')->onDelete('cascade');
            $table->string('file_name')->nullable();      
            $table->string('file_path')->nullable();
            $table->integer('urgent')->default(2)->comment('1=Urgent, 2=Not Urgent');
            $table->integer('favourites')->default(2)->comment('1=Favourite, 2=Not Favourite');
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
        Schema::dropIfExists('provider_documents');
    }
};
