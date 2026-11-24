<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSportToPrivateCoachingApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('private_coaching_application')) {
            Schema::table('private_coaching_application', function (Blueprint $table) {
                if (!Schema::hasColumn('private_coaching_application', 'sport')) {
                    $table->string('sport', 255)->nullable()->after('user_id');
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
        if (Schema::hasTable('private_coaching_application')) {
            Schema::table('private_coaching_application', function (Blueprint $table) {
                if (Schema::hasColumn('private_coaching_application', 'sport')) {
                    $table->dropColumn('sport');
                }
            });
        }
    }
}
