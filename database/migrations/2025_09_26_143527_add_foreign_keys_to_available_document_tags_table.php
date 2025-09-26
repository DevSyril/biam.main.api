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
        Schema::table('available_document_tags', function (Blueprint $table) {
            $table->foreign(['available_document_id'], 'available_document_tags_available_document_id_fkey')->references(['id'])->on('available_documents')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['tag_id'], 'available_document_tags_tag_id_fkey')->references(['id'])->on('tags')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_document_tags', function (Blueprint $table) {
            $table->dropForeign('available_document_tags_available_document_id_fkey');
            $table->dropForeign('available_document_tags_tag_id_fkey');
        });
    }
};
