<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_meta', function (Blueprint $table) {
            if (! Schema::hasColumn('seo_meta', 'browser_title')) {
                $table->string('browser_title')->nullable()->after('seo_title');
            }
            if (! Schema::hasColumn('seo_meta', 'secondary_keywords')) {
                $table->string('secondary_keywords')->nullable()->after('focus_keyword');
            }
            if (! Schema::hasColumn('seo_meta', 'h1_title')) {
                $table->string('h1_title')->nullable()->after('breadcrumb_title');
            }
            if (! Schema::hasColumn('seo_meta', 'structured_data_type')) {
                $table->string('structured_data_type', 100)->nullable()->after('schema_json');
            }
            if (! Schema::hasColumn('seo_meta', 'author')) {
                $table->string('author')->nullable()->after('structured_data_type');
            }
            if (! Schema::hasColumn('seo_meta', 'publish_date')) {
                $table->date('publish_date')->nullable()->after('author');
            }
            if (! Schema::hasColumn('seo_meta', 'seo_updated_date')) {
                $table->date('seo_updated_date')->nullable()->after('publish_date');
            }
            if (! Schema::hasColumn('seo_meta', 'reading_time')) {
                $table->unsignedSmallInteger('reading_time')->nullable()->after('seo_updated_date');
            }
            if (! Schema::hasColumn('seo_meta', 'twitter_card')) {
                $table->string('twitter_card', 50)->nullable()->after('twitter_image');
            }
        });

        Schema::table('media', function (Blueprint $table) {
            if (! Schema::hasColumn('media', 'description')) {
                $table->text('description')->nullable()->after('caption');
            }
            if (! Schema::hasColumn('media', 'lazy_load')) {
                $table->boolean('lazy_load')->default(true)->after('seo_name');
            }
        });

        if (! Schema::hasTable('seo_redirects')) {
            Schema::create('seo_redirects', function (Blueprint $table) {
                $table->id();
                $table->string('from_path')->unique();
                $table->string('to_url');
                $table->unsignedSmallInteger('status_code')->default(301);
                $table->boolean('is_active')->default(true);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_redirects');

        Schema::table('media', function (Blueprint $table) {
            if (Schema::hasColumn('media', 'lazy_load')) {
                $table->dropColumn('lazy_load');
            }
            if (Schema::hasColumn('media', 'description')) {
                $table->dropColumn('description');
            }
        });

        Schema::table('seo_meta', function (Blueprint $table) {
            $columns = [
                'browser_title',
                'secondary_keywords',
                'h1_title',
                'structured_data_type',
                'author',
                'publish_date',
                'seo_updated_date',
                'reading_time',
                'twitter_card',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('seo_meta', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
