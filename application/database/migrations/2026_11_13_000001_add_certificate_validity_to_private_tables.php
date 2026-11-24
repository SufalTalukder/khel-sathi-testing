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
        $tables = [
            'private_coaching_application',
            'private_gym_application',
            'private_academies_application',
            'private_swimming_pool_application'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    if (!Schema::hasColumn($table, 'certificate_valid_upto')) {
                        $t->date('certificate_valid_upto')->nullable()->after('certificate_issue_date');
                    }
                    if (!Schema::hasColumn($table, 'certificate_validity')) {
                        $t->string('certificate_validity', 100)->nullable()->after('certificate_valid_upto');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'private_coaching_application',
            'private_gym_application',
            'private_academies_application',
            'private_swimming_pool_application'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    if (Schema::hasColumn($table, 'certificate_validity')) {
                        $t->dropColumn('certificate_validity');
                    }
                    if (Schema::hasColumn($table, 'certificate_valid_upto')) {
                        $t->dropColumn('certificate_valid_upto');
                    }
                });
            }
        }
    }
};
