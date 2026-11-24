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
        $existingPage = DB::table('urm_page_manager')
            ->where('page_url', 'admin/eklavya_krida_co/query_marked')
            ->first();

        if (!$existingPage) {
            $pendingPage = DB::table('urm_page_manager')
                ->where('page_url', 'admin/eklavya_krida_co/6')
                ->first();

            $moduleId = $pendingPage ? $pendingPage->module_id : 15;
            $parent = $pendingPage ? $pendingPage->page_parent : 88;
            $order = $pendingPage ? ($pendingPage->page_order + 1) : 7;

            $pageId = DB::table('urm_page_manager')->insertGetId([
                'page_name'   => 'Query Marked Applications',
                'page_url'    => 'admin/eklavya_krida_co/query_marked',
                'module_id'   => $moduleId,
                'page_parent' => $parent,
                'page_order'  => $order,
                'is_menu'     => 1,
                'menu_icon'   => 'icon icon-eye',
                'page_status' => 1,
            ]);

            // Give permission to admin users who have admin_role IN (1, 2, 3, 5, 9, 17)
            $allowedUsers = DB::table('admin')
                ->whereIn('admin_role', [1, 2, 3, 5, 9, 17])
                ->pluck('id');

            foreach ($allowedUsers as $adminUserId) {
                $exists = DB::table('urm_role_module_mapping')
                    ->where('user_id', $adminUserId)
                    ->where('page_id', $pageId)
                    ->exists();

                if (!$exists) {
                    DB::table('urm_role_module_mapping')->insert([
                        'user_id' => $adminUserId,
                        'page_id' => $pageId,
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
            DB::table('urm_role_module_mapping')->where('page_id', $page->id)->delete();
            DB::table('urm_page_manager')->where('id', $page->id)->delete();
        }
    }
};
