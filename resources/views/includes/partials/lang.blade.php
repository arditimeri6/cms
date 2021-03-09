<ul class="dropdown-menu lang-menu" role="menu">
        @foreach (config('global_settings.languages') as $lang)
                @if ($lang['slug'] != App::getLocale())
                        <li>{{ link_to('lang/'.$lang['slug'], $lang['name']) }}</li>
                @endif
        @endforeach
</ul>