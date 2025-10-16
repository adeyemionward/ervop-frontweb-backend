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
        Schema::create('website_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('page'); // ✅ NEW: 'home', 'faq', 'about', 'services', 'contact'
            $table->string('section_type'); // ✅ SAME FOR ALL: 'hero', 'about', 'services'
            $table->string('content_key');  // ✅ SAME FOR ALL: 'tagline', 'headline', 'description'
            $table->text('content_value');  // ✅ UNIQUE PER BUSINESS: Actual generated text
            $table->integer('is_visible')->default(1); 
            $table->integer('tokens_used')->default(0);
            $table->integer('word_count')->default(0);
            $table->timestamps();


            // Index for faster queries
            $table->index(['section_type', 'content_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};
