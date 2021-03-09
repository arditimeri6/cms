<?php

namespace App\Repositories\Frontend\Blogs;

use App\Exceptions\GeneralException;
use App\Models\BlogCategories\BlogCategory;
use App\Models\Blogs\Blog;
use App\Repositories\BaseRepository;

class BlogsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Blog::class;

    /*
     * Find page by page_slug
     */
    public function getBlogPosts()
    {
        $blog_category = BlogCategory::where('status', BlogCategory::BLOG_STATUS)->first();
        $posts = $blog_category->blogs()->where('name->'.config('app.locale'), '<>', '')->get();

        return $posts;
    }

    public function findBySlug($slug)
    {
        $locale = config('app.locale');
        $blog_category = BlogCategory::where('status', BlogCategory::BLOG_STATUS)->first();
        $post = $blog_category->blogs()->where("slug->{$locale}", $slug)->first();

        if (!is_null($post)) {
            return $post;
        }

        throw new GeneralException(trans('exceptions.backend.access.pages.not_found'));
    }
}
