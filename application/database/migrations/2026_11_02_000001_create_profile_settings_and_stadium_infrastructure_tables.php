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
        // 1. Add salutation and profile_image to admin table if not exists
        if (Schema::hasTable('admin')) {
            Schema::table('admin', function (Blueprint $table) {
                if (!Schema::hasColumn('admin', 'salutation')) {
                    $table->string('salutation', 20)->nullable()->after('name');
                }
                if (!Schema::hasColumn('admin', 'profile_image')) {
                    $table->string('profile_image', 255)->nullable()->after('designation');
                }
            });
        }

        // 2. Add address to studium_master table if not exists
        if (Schema::hasTable('studium_master') && !Schema::hasColumn('studium_master', 'address')) {
            Schema::table('studium_master', function (Blueprint $table) {
                $table->text('address')->nullable()->after('studium_name');
            });
        }

        // 3. Create stadium_infrastructures table if not exists
        if (!Schema::hasTable('stadium_infrastructures')) {
            Schema::create('stadium_infrastructures', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('stadium_id')->index();
                $table->string('infrastructure_name', 255);
                $table->string('available_games', 255)->nullable();
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('stadium_infrastructures');

        if (Schema::hasTable('studium_master') && Schema::hasColumn('studium_master', 'address')) {
            Schema::table('studium_master', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }

        if (Schema::hasTable('admin') && Schema::hasColumn('admin', 'profile_image')) {
            Schema::table('admin', function (Blueprint $table) {
                $table->dropColumn('profile_image');
            });
        }
    }
};
