<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $page = DB::table('urm_page_manager')
            ->where('page_url', 'admin/eklavya_krida_co/query_marked')
            ->first();

        if ($page) {
            $allowedUsers = DB::table('admin')
                ->whereIn('admin_role', [2, 3, 9])
                ->pluck('id');

            foreach ($allowedUsers as $adminUserId) {
                $exists = DB::table('urm_role_module_mapping')
                    ->where('user_id', $adminUserId)
                    ->where('page_id', $page->id)
                    ->exists();

                if (!$exists) {
                    DB::table('urm_role_module_mapping')->insert([
                        'user_id' => $adminUserId,
                        'page_id' => $page->id,
                        'dor'     => date('Y-m-d H:i:s'),
                    ]);
                }
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
        $page = DB::table('urm_page_manager')
            ->where('page_url', 'admin/eklavya_krida_co/query_marked')
            ->first();

        if ($page) {
            $roleUsers = DB::table('admin')
                ->whereIn('admin_role', [2, 3, 9])
                ->pluck('id');

            DB::table('urm_role_module_mapping')
                ->where('page_id', $page->id)
                ->whereIn('user_id', $roleUsers)
                ->delete();
        }
    }
};
