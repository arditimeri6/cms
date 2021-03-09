<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Blogs\BlogsRepository;
use Illuminate\Http\Request;
use Theme;

class FrontendBlogController extends Controller
{
    protected $blogs;

    public function __construct(BlogsRepository $blogs)
    {
        $this->blogs = $blogs;
    }

    public function index()
    {
        $posts = $this->blogs->getBlogPosts();

        return Theme::view('blogs.index', ['posts' => $posts]);
    }

    public function blogPage(Request $request, $slug)
    {
        $post = $this->blogs->findBySlug($slug);

        return Theme::view('blogs.page', ['post' => $post]);
    }
}
