<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            DB::statement("ALTER TABLE stadium_infrastructures MODIFY infrastructure_name TEXT NOT NULL, MODIFY available_games TEXT NULL");
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
            DB::statement("ALTER TABLE stadium_infrastructures MODIFY infrastructure_name VARCHAR(255) NOT NULL, MODIFY available_games VARCHAR(255) NULL");
        }
    }
};
