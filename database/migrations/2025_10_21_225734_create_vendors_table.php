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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('firstname'); // required, string, max:255
            $table->string('lastname');  // required, string, max:255
            $table->string('email')->nullable(); // required, string, email, unique:contacts
            $table->string('phone')->unique(); // required, string, unique:contacts
            $table->string('company')->nullable(); // nullable, string, max:255
            $table->string('address')->nullable(); // nullable (assuming you're storing the filename as a string)
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
