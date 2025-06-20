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
        Schema::table('users', function (Blueprint $table) {
            $table->string('producer_name', 255)->after('profile_photo');
            $table->string('importer_name', 255)->after('producer_name');
            $table->string('bio', 500)->nullable()->after('importer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['producer_name', 'importer_name', 'bio']);
        });
    }
};
