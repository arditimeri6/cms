<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('access.menus_table'))->truncate();
        $menu = [
            'id' => 1,
            'type' => 'backend',
            'name' => 'Backend Sidebar Menu',
            'items' => '[{"id":2,"name":"Pages","url":"admin.pages.index","url_type":"route","open_in_new_tab":0,"icon":"fa-file-text","view_permission_id":"view-page","content":"Pages"},{"view_permission_id":"view-blog","icon":"fa-commenting","open_in_new_tab":0,"url_type":"route","url":"","name":"Post Management","id":15,"content":"Post Management","children":[{"view_permission_id":"view-blog-category","icon":"","open_in_new_tab":0,"url_type":"route","url":"admin.blogCategories.index","name":"Post Category Management","id":16,"content":"Post Category Management"},{"view_permission_id":"view-blog-tag","icon":"","open_in_new_tab":0,"url_type":"route","url":"admin.blogTags.index","name":"Post Tag Management","id":17,"content":"Post Tag Management"},{"view_permission_id":"view-blog","icon":"","open_in_new_tab":0,"url_type":"route","url":"admin.blogs.index","name":"Post Management","id":18,"content":"Post Management"}]},{"id":11,"name":"Access Management","url":"","url_type":"route","open_in_new_tab":0,"icon":"fa-users","view_permission_id":"view-access-management","content":"Access Management","children":[{"id":12,"name":"User Management","url":"admin.access.user.index","url_type":"route","open_in_new_tab":0,"view_permission_id":"view-user-management","content":"User Management"},{"id":13,"name":"Role Management","url":"admin.access.role.index","url_type":"route","open_in_new_tab":0,"view_permission_id":"view-role-management","content":"Role Management"},{"id":14,"name":"Permission Management","url":"admin.access.permission.index","url_type":"route","open_in_new_tab":0,"view_permission_id":"view-permission-management","content":"Permission Management"}]},{"view_permission_id":"edit-theme","icon":"fa-files-o","open_in_new_tab":0,"url_type":"route","url":"admin.themes.index","name":"Themes","id":20,"content":"Themes"},{"id":3,"name":"Menus","url":"admin.menus.index","url_type":"route","open_in_new_tab":0,"icon":"fa-bars","view_permission_id":"view-menu","content":"Menus"},{"id":22,"name":"Settings","url":"","url_type":"static","open_in_new_tab":0,"icon":"fa-gear","view_permission_id":"","content":"Settings","children":[{"view_permission_id":"edit-settings","icon":"","open_in_new_tab":0,"url_type":"route","url":"admin.settings.edit?id=1","name":"All Settings","id":9,"content":"All Settings"},{"view_permission_id":"","icon":"","open_in_new_tab":0,"url_type":"route","url":"admin.languages.index","name":"Languages","id":21,"content":"Languages"}]}]',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ];

        DB::table(config('access.menus_table'))->insert($menu);
    }
}
