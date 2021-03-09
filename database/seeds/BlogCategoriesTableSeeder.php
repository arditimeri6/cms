<?php

use Carbon\Carbon;
use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategoriesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate(config('module.blog_categories.table'));

        $blog = [
            [
                'name'       => 'Blog',
                'status'   => \App\Models\BlogCategories\BlogCategory::BLOG_STATUS,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ];

        DB::table(config('module.blog_categories.table'))->insert($blog);

        $this->enableForeignKeys();
    }
}
