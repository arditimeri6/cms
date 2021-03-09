<?php

namespace App\Http\Controllers\Backend\Languages;

use App\Http\Controllers\Controller;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Languages\ManageLanguageRequest;
use App\Http\Requests\Backend\Languages\CreateLanguageRequest;
use App\Http\Requests\Backend\Languages\StoreLanguageRequest;
use App\Http\Requests\Backend\Languages\EditLanguageRequest;
use App\Http\Requests\Backend\Languages\UpdateLanguageRequest;
use App\Http\Requests\Backend\Languages\DeleteLanguageRequest;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageLanguageRequest $request)
    {
        $languages = settings()->languages;
        if (!$languages) {
            $languages = [];
        }

        return view('backend.languages.index', ['languages' => $languages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateLanguageRequest $request)
    {
        return new ViewResponse('backend.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguageRequest $request)
    {
        $settings = settings();
        $languages = $settings->languages;
        $new_language = ['name' => $request->name, 'slug' => $request->slug, 'default' => $request->default];

        if (!$languages) {
            $languages = [];
        }

        if (inArrayRec($request->name, $languages) || inArrayRec($request->slug, $languages)) {
            return new RedirectResponse(route('admin.languages.index'), ['flash_danger' => trans('alerts.backend.languages.exists')]);
        }

        if ($request->default) {
            $languages = $this->destroyDefaultFromLanguage($languages); 
        }

        array_push($languages, $new_language);
        $settings->languages = $languages;
        $settings->save();

        return new RedirectResponse(route('admin.languages.index'), ['flash_success' => trans('alerts.backend.languages.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditLanguageRequest $request, $id)
    {
        $settings = settings();
        $languages = $settings->languages;
        foreach ($languages as $key => $language) {
            if ($language['slug'] == $id) {
                break;
            }
        }

        return new ViewResponse('backend.languages.edit', ['language' => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguageRequest $request, $id)
    {
        $settings = settings();
        $languages = $this->destroyLanguage($settings->languages, $id);

        $new_language = ['name' => $request->name, 'slug' => $request->slug, 'default' => $request->default];

        if ($request->default) {
            $languages = $this->destroyDefaultFromLanguage($languages);
            $new_language['default'] = $request->default;
        }

        if(!$request->default && $this->checkDefaultLanguage($languages) == '') {
            $new_language['default'] = 1;
        }

        array_push($languages, $new_language);
        $settings->languages = $languages;
        $settings->save();

        return new RedirectResponse(route('admin.languages.index'), ['flash_success' => trans('alerts.backend.languages.updated')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteLanguageRequest $request, $id)
    {
        $settings = settings();
        $languages = $settings->languages;

        if($this->checkIfLanguageIsDefault($languages, $id)) {
            return new RedirectResponse(route('admin.languages.index'), ['flash_danger' => trans('alerts.backend.languages.can_not_delete')]);
        }

        $updated_languages = $this->destroyLanguage($settings->languages, $id);

        $settings->languages = $updated_languages;
        $settings->save();

        return new RedirectResponse(route('admin.languages.index'), ['flash_success' => trans('alerts.backend.languages.deleted')]);
    }

    protected function destroyDefaultFromLanguage($languages)
    {
        foreach ($languages as $key => $language) {
            $languages[$key]['default'] = 0;
        }

        return $languages;
    }

    protected function destroyLanguage($languages, $id)
    {
        foreach ($languages as $key => $language) {
            if ($language['slug'] == $id) {
                unset($languages[$key]);
            }
        }

        return $languages;
    }

    protected function checkDefaultLanguage($languages) 
    {
        foreach ($languages as $key => $language) {
            if ($language['default']) {
                return $language['slug'];
            }
        }

        return '';
    }

    protected function checkIfLanguageIsDefault($languages, $id)
    {
        foreach ($languages as $key => $language) {
            if ($language['slug'] == $id && $language['default']) {
                return true;
            }
        }

        return false;
    }
}
