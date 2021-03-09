<?php

namespace App;

class Localization
{
    public static function setLocale()
    {
        $locale = app()->request->segment(1);

        if ($locale == null) {
            $locale = self::defaultLanguage();
        }

        if (!self::checkAvailabelLanguages($locale)) {
            $locale = self::defaultLanguage();
        }

        app()->setLocale($locale);

        return $locale;
    }

    public static function checkAvailabelLanguages($locale)
    {
        $languages = config('global_settings.languages');
        foreach ($languages as $key => $language) {
            if ($language['slug'] == $locale) {
                return true;
            }
        }

        return false;
    }

    public static function defaultLanguage()
    {
        $languages = config('global_settings.languages');
        foreach ($languages as $key => $language) {
            if ($language['default']) {
                return $language['slug'];
            }
        }

        return 'en';
    }
}
