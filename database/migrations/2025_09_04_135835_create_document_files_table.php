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
        Schema::create('document_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->string('file_path'); // path or URL to the uploaded file
            $table->string('file_type')->nullable(); // optional: store mime-type or extension
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_files');
    }
};
