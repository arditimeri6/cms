<?php

namespace App\Repositories\Backend\Pages;

use App\Events\Backend\Pages\PageCreated;
use App\Events\Backend\Pages\PageDeleted;
use App\Events\Backend\Pages\PageUpdated;
use App\Exceptions\GeneralException;
use App\Models\Page\Page;
use Carbon\Carbon;
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

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        $locale = config('app.locale');
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.pages.table').'.created_by')
            ->select([
                config('module.pages.table').'.id',
                config('module.pages.table').".title->{$locale} as title",
                config('module.pages.table').".page_slug->{$locale} as slug",
                config('module.pages.table').'.status',
                config('module.pages.table').'.created_at',
                config('module.pages.table').'.updated_at',
                config('access.users_table').'.first_name as created_by',
            ]);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        if ($this->query()->where('title', $input['title'])->first()) {
            throw new GeneralException(trans('exceptions.backend.pages.already_exists'));
        }

        // Making extra fields
        $input['page_slug'] = $this->pageSlug($input['title']);
        $input['publish_datetime'] = Carbon::parse($input['publish_datetime']);
        $input['status'] = isset($input['status']) ? 1 : 0;
        $input['created_by'] = auth()->id();

        if ($page = Page::create($input)) {
            event(new PageCreated($page));

            return $page;
        }

        throw new GeneralException(trans('exceptions.backend.pages.create_error'));
    }

    /**
     * @param \App\Models\Page\Page $page
     * @param array                 $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function update($page, array $input)
    {
        if ($this->query()->where("title->".config('app.locale'), $input['title'])->where('id', '!=', $page->id)->first()) {
            throw new GeneralException(trans('exceptions.backend.pages.already_exists'));
        }
        // Making extra fields
        if ($this->checkSlugExists($input['page_slug'], $page->id)) {
            unset($input['page_slug']);
        }

        $input['publish_datetime'] = Carbon::parse($input['publish_datetime']);

        if($page->status != constant(self::MODEL.'::HOME')) {
            $input['status'] = isset($input['status']) ? 1 : 0;
        }

        $input['updated_by'] = access()->user()->id;

        if ($page->update($input)) {
            event(new PageUpdated($page));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.pages.update_error'));
    }

    /**
     * @param \App\Models\Page\Page $page
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function delete($page)
    {
        if ($page->delete()) {
            event(new PageDeleted($page));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.pages.delete_error'));
    }

    protected function checkSlugExists($page_slug, $page_id = 0) {

        $check = $this->query()->where('id', '<>', $page_id)->where("page_slug->".config('app.locale'), $page_slug)->withTrashed()->first();

        if($check) {
            return true;
        }

        return false;
    }

    protected function pageSlug($title, $page = null)
    {
        $slug = str_slug($title);

        if(optional($page)->page_slug) {
            $slug = $page->page_slug;
        }

        if($this->checkSlugExists($slug, optional($page)->id)) {
            return $this->pageSlug($title .' '. rand(1, 100), $page);
        }

        return $slug;
    }

}
