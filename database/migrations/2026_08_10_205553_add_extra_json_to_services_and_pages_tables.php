<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('long_description');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->json('extra')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('extra');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('extra');
        });
    }
};
