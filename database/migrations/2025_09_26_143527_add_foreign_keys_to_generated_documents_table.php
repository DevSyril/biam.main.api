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
        Schema::table('generated_documents', function (Blueprint $table) {
            $table->foreign(['template_id'], 'generated_documents_template_id_fkey')->references(['id'])->on('templates')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'], 'generated_documents_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generated_documents', function (Blueprint $table) {
            $table->dropForeign('generated_documents_template_id_fkey');
            $table->dropForeign('generated_documents_user_id_fkey');
        });
    }
};
