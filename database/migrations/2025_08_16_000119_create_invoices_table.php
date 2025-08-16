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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');

            // Invoice details
            $table->string('invoice_no');
            $table->string('invoice_type')->default('Project'); // e.g., Project, Service, etc.
            $table->date('issue_date');
            $table->date('due_date');

            // Financials - Using decimal for precision with currency
            $table->decimal('tax', 10, 2)->nullable()->default(0.00);
            $table->decimal('discount', 10, 2)->nullable()->default(0.00);

            // Other info
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
