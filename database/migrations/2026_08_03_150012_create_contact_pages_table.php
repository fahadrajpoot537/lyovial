<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->string('heading')->nullable();
            $table->text('description')->nullable();
            $table->string('form_heading')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->longText('map_embed')->nullable();
            $table->string('what_to_include_heading')->nullable();
            $table->longText('what_to_include_content')->nullable();
            $table->string('how_can_we_help_heading')->nullable();
            $table->longText('how_can_we_help_content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_pages');
    }
};
