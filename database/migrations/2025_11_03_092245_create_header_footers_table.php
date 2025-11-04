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
        Schema::create('header_footers', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('template_id');
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type', ['header', 'footer']);
            $table->boolean('is_active')->default(true);
            $table->string('content');
            $table->boolean('show_on_first_page')->default(true);
            $table->boolean('show_on_last_page')->default(false);
            $table->boolean('show_on_all_pages')->default(false);
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#000000');
            $table->integer('font_size')->default('100');
            $table->string('font_family')->default('Arial');
            $table->enum('font_style', ['normal', 'italic', 'bold'])->default('normal');
            $table->enum('text_position', ['left', 'center', 'right'])->default('left');
            $table->boolean('has_logo')->default(false);
            $table->string('logo_url')->nullable();
            $table->enum('border', ['none', 'top', 'bottom', 'both'])->default('none');
            $table->timestamps();

            $table->unique(['template_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_footers');
    }
};
