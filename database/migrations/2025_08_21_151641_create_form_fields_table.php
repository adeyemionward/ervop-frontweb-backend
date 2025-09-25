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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('type'); // e.g., text, textarea, dropdown
            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(false);
            $table->json('options')->nullable(); // For dropdowns, radios, etc.
            $table->unsignedInteger('order')->default(0); // To maintain drag-and-drop order
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
