<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('disk', 50)->default('public');
            $table->string('path');
            $table->string('webp_path')->nullable();
            $table->string('filename');
            $table->string('original_name');
            $table->string('mime_type', 100)->nullable();
            $table->string('extension', 20)->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('seo_name')->nullable();
            $table->string('folder', 150)->default('uploads')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['mime_type', 'folder']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
