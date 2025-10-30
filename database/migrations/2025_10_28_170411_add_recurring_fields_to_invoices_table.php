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
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false)->after('total');
            $table->string('repeats')->nullable()->after('is_recurring'); // e.g. daily, weekly, monthly, yearly
            $table->date('occuring_start_date')->nullable()->after('repeats');
            $table->date('occuring_end_date')->nullable()->after('occuring_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'repeats', 'occuring_start_date', 'occuring_end_date']);

        });
    }
};
