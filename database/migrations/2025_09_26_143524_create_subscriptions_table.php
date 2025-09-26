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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('name')->unique('subscriptions_name_key');
            $table->decimal('price', 10)->default(0);
            $table->text('description')->nullable();
            $table->integer('max_documents_per_month')->nullable();
            $table->integer('max_storage_gb')->nullable();
            $table->jsonb('features')->nullable()->default('[]');
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestampTz('created_at')->nullable()->useCurrent();
            $table->timestampTz('updated_at')->nullable()->useCurrent();
        });
        DB::statement("alter table \"subscriptions\" add column \"type\" subscription_type not null");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
