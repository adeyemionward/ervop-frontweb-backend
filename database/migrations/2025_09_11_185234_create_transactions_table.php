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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
             // Foreign keys to link the payment to its owners and sources
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');

            // Payment-specific details
            $table->decimal('amount', 10, 2); // Using decimal for precise currency values
            $table->date('date');
            $table->string('payment_method')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable(); //expenses, income
            $table->text('title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
