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
        Schema::connection('pgsql_secondary')->create('legal_text', function (Blueprint $table) {
            $table->uuid('id')->default('uuid_generate_v4()')->primary();
            $table->string('title', 500);
            $table->enum('text_type', ['Constitution', 'Code', 'Law', 'Decree', 'Interministerial_Order', 'OHADA_Uniform_Act', 'Regulation', 'Other']);
            $table->string('official_number', 200)->nullable();
            $table->date('promulgation_date')->index('idx_legal_text_promulgation');
            $table->date('abrogation_date')->nullable();
            $table->boolean('is_in_force')->nullable()->storedAs('(abrogation_date IS NULL)')->index('idx_legal_text_in_force');
            $table->text('official_source')->nullable();
            $table->string('version', 100)->nullable();
            $table->string('applicable_country', 100)->nullable()->default('Togo');
            $table->string('jurisdiction', 100)->nullable()->default('National')->index('idx_legal_text_jurisdiction');
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
            $table->timestampTz('updated_at')->nullable()->default(DB::raw("now()"));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('legal_text');
    }
};
