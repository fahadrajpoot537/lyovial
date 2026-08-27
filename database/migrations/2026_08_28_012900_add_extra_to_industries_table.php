<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            if (! Schema::hasColumn('industries', 'extra')) {
                $table->json('extra')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            if (Schema::hasColumn('industries', 'extra')) {
                $table->dropColumn('extra');
            }
        });
    }
};
