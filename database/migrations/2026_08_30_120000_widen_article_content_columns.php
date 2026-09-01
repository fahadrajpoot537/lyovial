<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE articles MODIFY title VARCHAR(500) NOT NULL');
            DB::statement('ALTER TABLE articles MODIFY excerpt TEXT NULL');
            DB::statement('ALTER TABLE articles MODIFY content LONGTEXT NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY meta_keywords TEXT NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY secondary_keywords TEXT NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY canonical_url VARCHAR(500) NULL');

            return;
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->string('title', 500)->change();
            $table->text('excerpt')->nullable()->change();
            $table->longText('content')->nullable()->change();
        });
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE articles MODIFY title VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE articles MODIFY excerpt VARCHAR(255) NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY meta_keywords VARCHAR(255) NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY secondary_keywords VARCHAR(255) NULL');
            DB::statement('ALTER TABLE seo_meta MODIFY canonical_url VARCHAR(255) NULL');
        }
    }
};
