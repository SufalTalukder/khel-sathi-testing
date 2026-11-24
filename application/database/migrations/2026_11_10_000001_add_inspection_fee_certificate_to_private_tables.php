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
                    if (!Schema::hasColumn($table, 'rejection_doc')) {
                        $t->string('rejection_doc', 255)->nullable()->after('remark');
                    }
                    if (!Schema::hasColumn($table, 'inspection_date')) {
                        $t->date('inspection_date')->nullable();
                    }
                    if (!Schema::hasColumn($table, 'inspection_report')) {
                        $t->string('inspection_report', 255)->nullable();
                    }
                    if (!Schema::hasColumn($table, 'protsahan_samiti_fee')) {
                        $t->decimal('protsahan_samiti_fee', 10, 2)->nullable();
                    }
                    if (!Schema::hasColumn($table, 'fee_status')) {
                        $t->tinyInteger('fee_status')->default(0)->comment('0: Unpaid, 1: Paid');
                    }
                    if (!Schema::hasColumn($table, 'fee_paid_date')) {
                        $t->date('fee_paid_date')->nullable();
                    }
                    if (!Schema::hasColumn($table, 'certificate_file')) {
                        $t->string('certificate_file', 255)->nullable();
                    }
                    if (!Schema::hasColumn($table, 'certificate_issue_date')) {
                        $t->date('certificate_issue_date')->nullable();
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

        $columns = [
            'rejection_doc',
            'inspection_date',
            'inspection_report',
            'protsahan_samiti_fee',
            'fee_status',
            'fee_paid_date',
            'certificate_file',
            'certificate_issue_date'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $t) use ($table, $columns) {
                    foreach ($columns as $column) {
                        if (Schema::hasColumn($table, $column)) {
                            $t->dropColumn($column);
                        }
                    }
                });
            }
        }
    }
};
