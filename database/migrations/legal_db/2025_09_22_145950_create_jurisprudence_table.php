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
        Schema::connection('pgsql_secondary')->create('jurisprudence', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'))->primary();
            $table->string('case_reference', 500);
            $table->string('defendant_names', 500);
            $table->string('claimant_names', 500);
            $table->string('court');
            $table->text('summary');
            $table->longText('full_decision')->nullable();
            $table->date('decision_date');
            $table->text('official_link')->nullable();
            $table->uuid('linked_subject_id')->nullable()->index('idx_jurisprudence_subject');
            $table->timestampTz('created_at')->nullable()->default(DB::raw("now()"));
            $table->timestampTz('updated_at')->nullable()->default(DB::raw("now()"));
            $table->foreign('linked_subject_id')->references('id')->on('legal_subject')->onUpdate('no action')->onDelete('set null');

            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->dropIfExists('jurisprudence');
    }
};
