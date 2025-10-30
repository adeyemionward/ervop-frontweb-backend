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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->nullable()->constrained('contacts')->onDelete('set null');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');

            $table->string('quotation_no')->nullable()->unique();
            $table->string('quotation_type')->nullable(); // e.g., Project, Service, etc.

            $table->date('issue_date');
            $table->date('valid_until')->nullable();

            $table->decimal('tax_percentage', 5, 2)->default(0.00);
            $table->decimal('discount_percentage', 5, 2)->default(0.00);

            $table->decimal('tax_amount', 15, 2)->default(0.00);
            $table->decimal('subtotal', 15, 2)->default(0.00);
            $table->decimal('discount', 15, 2)->default(0.00);
            $table->decimal('total', 15, 2)->default(0.00);

            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // e.g. pending, accepted, rejected

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
