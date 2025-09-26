<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('email')->index('idx_users_email');
            $table->string('phone', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('occupation')->nullable();
            $table->boolean('professional_account')->nullable()->default(false);
            $table->boolean('is_verified')->nullable()->default(false);
            $table->uuid('subscription_id')->index('idx_users_subscription');
            $table->string('password_hash');
            $table->timestampTz('last_login')->nullable();
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();

            $table->unique(['email'], 'users_email_key');
        });
        DB::statement("alter table \"users\" add column \"role\" user_role null default 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
