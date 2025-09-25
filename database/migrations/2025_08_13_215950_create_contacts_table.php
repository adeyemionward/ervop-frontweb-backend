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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('firstname'); // required, string, max:255
            $table->string('lastname');  // required, string, max:255
            $table->string('email')->nullable(); // required, string, email, unique:contacts
            $table->string('phone')->unique(); // required, string, unique:contacts
            $table->string('company')->nullable(); // nullable, string, max:255
            $table->string('photo')->nullable(); // nullable (assuming you're storing the filename as a string)
            $table->text('tags')->nullable(); // nullable, string (using 'text' to allow for longer strings, e.g., a comma-separated list of tags)
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
