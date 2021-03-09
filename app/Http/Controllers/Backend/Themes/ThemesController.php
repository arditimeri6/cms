<?php

namespace App\Http\Controllers\Backend\Themes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Themes\CreateThemeRequest;
use App\Http\Requests\Backend\Themes\DeleteThemeRequest;
use App\Http\Requests\Backend\Themes\ManageThemeRequest;
use App\Http\Requests\Backend\Themes\StoreThemeRequest;
use App\Http\Requests\Backend\Themes\UpdateThemeRequest;
use App\Http\Requests\Backend\Themes\EditThemeRequest;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Http\Request;
use Theme;

class ThemesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageThemeRequest $request)
    {
        $themes = Theme::all();
        $activated_theme = settings()->theme['name'];
        return view('backend.themes.index', ['themes' => $themes, 'activated_theme' => $activated_theme]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateThemeRequest $request)
    {
        return new ViewResponse('backend.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreThemeRequest $request)
    {
        \Artisan::call('theme:create', ['name' => $request->name]);

        return new RedirectResponse(route('admin.themes.index'), ['flash_success' => trans('alerts.backend.themes.created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditThemeRequest $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateThemeRequest $request, $theme)
    {
        $settings = settings();
        $options = $settings->theme;
        $options['name'] = $theme;
        $settings->theme = $options;
        $settings->save();

        return new RedirectResponse(route('admin.themes.index'), ['flash_success' => trans('alerts.backend.themes.selected')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteThemeRequest $request, File $file, $theme)
    {
        $path = public_path() . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $theme;
        //chack selected theme activation
        if (settings()->theme['name'] == $theme) {
            return new RedirectResponse(route('admin.themes.index'), ['flash_danger' => trans('alerts.backend.themes.selected_activated_theme')]);
        }
        // The theme is not exists.
        if (!$file->isDirectory($path)) {
            return new RedirectResponse(route('admin.themes.index'), ['flash_danger' => trans('alerts.backend.themes.does_not_exist')]);
        }

        $file->deleteDirectory($path, false);

        return new RedirectResponse(route('admin.themes.index'), ['flash_success' => trans('alerts.backend.themes.deleted')]);
    }
}
