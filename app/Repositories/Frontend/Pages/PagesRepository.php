<?php

namespace App\Repositories\Frontend\Pages;

use App\Exceptions\GeneralException;
use App\Models\Page\Page;
use App\Repositories\BaseRepository;

/**
 * Class PagesRepository.
 */
class PagesRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Page::class;

    /*
     * Find page by page_slug
     */
    public function findBySlug($page_slug)
    {
        $locale  = config('app.locale');
        $page = $this->query()->where("page_slug->{$locale}", $page_slug)->active()->first();

        if (!is_null($page)) {
            return $page;
        }
        throw new GeneralException(trans('exceptions.backend.access.pages.not_found'));
    }

    /*
     * Get Home (Default) Page
     */
    public function getHomePage()
    {
        $page = $this->query()->where("status", constant(self::MODEL . '::HOME'))->first();

        if (!is_null($page)) {
            return $page;
        }
        throw new GeneralException(trans('exceptions.backend.access.pages.not_found'));
    }
}
