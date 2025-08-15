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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('business_type')->nullable();
            $table->string('business_name')->unique();
            $table->string('business_industry')->nullable();
            $table->string('ervop_url')->unique();
            $table->string('website')->unique()->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->unique();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('password');
            $table->string('user_type')->default('user'); // 'user' or 'admin'
            $table->string('status')->nullable(); // 'active', 'inactive', 'banned'
            $table->string('business_logo')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('social_links')->nullable(); // JSON or text for social media links

            $table->string('verification_token')->nullable();
            $table->timestamp('verification_token_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);


            $table->boolean('is_two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->string('two_factor_recovery_codes')->nullable();

            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_until')->nullable();
            $table->string('suspension_reason')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('locale')->default('en'); // Default locale
            $table->string('timezone')->default('UTC'); // Default timezone
            $table->string('theme')->default('light'); // Default theme
            $table->boolean('is_email_subscribed')->default(true); // For newsletters or updates
            $table->boolean('is_sms_subscribed')->default(false); // For SMS notifications
            $table->boolean('is_push_subscribed')->default(false); // For push notifications
            $table->string('language')->default('en'); // Default language preference
            $table->string('currency')->default('NGN'); // Default currency preference
            $table->string('referral_code')->nullable(); // For referral programs
            $table->string('referred_by')->nullable(); // User who referred this user
            $table->string('last_activity')->nullable(); // Last activity timestamp

            $table->string('subscription_plan')->default('free'); // 'free', 'basic', 'pro', 'enterprise'
            $table->timestamp('subscription_ends_at')->nullable(); // For subscription management
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
