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
        Schema::connection('pgsql_secondary')->table('legal_subject', function (Blueprint $table) {
            $table->foreign(['parent_id'], 'legal_subject_parent_id_fkey')->references(['id'])->on('legal_subject')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_secondary')->table('legal_subject', function (Blueprint $table) {
            $table->dropForeign('legal_subject_parent_id_fkey');
        });
    }
};
