<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Pages\PagesRepository;
use Theme;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    protected $pages;

    public function __construct(PagesRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // $settingData = Setting::first();
        // $google_analytics = $settingData->google_analytics;

        $home_page = $this->pages->getHomePage();
        return Theme::view('index', ['page' => $home_page]);
        // return view('frontend.index', compact('google_analytics', $google_analytics));
    }

    /**
     * show page by $page_slug.
     */
    public function showPage($slug)
    {
        $page = $this->pages->findBySlug($slug);

        if($page->status == \App\Models\Page\Page::HOME) {
            return Theme::view('index', ['page' => $page]);
        }

        if($page->template) {
            return Theme::view($page->template, ['page' => $page]);
        }

        return Theme::view('page', ['page' => $page]);
        // return view('frontend.pages.index')->withpage($result);
    }
}
