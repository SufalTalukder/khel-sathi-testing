<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('stadium_infrastructures')) {
            Schema::table('stadium_infrastructures', function (Blueprint $table) {
                if (!Schema::hasColumn('stadium_infrastructures', 'updated_by')) {
                    $table->unsignedBigInteger('updated_by')->nullable()->after('available_games');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('stadium_infrastructures')) {
            Schema::table('stadium_infrastructures', function (Blueprint $table) {
                if (Schema::hasColumn('stadium_infrastructures', 'updated_by')) {
                    $table->dropColumn('updated_by');
                }
            });
        }
    }
};
