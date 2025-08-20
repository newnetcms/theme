<?php

namespace Newnet\Theme\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Newnet\Theme\Facades\Theme;

class ThemeTranslateController extends Controller
{
    public function index(Request $request)
    {
        $currentLocale = $request->input('edit_locale') ?: app()->getLocale();

        $origins = $this->getOrigins($currentLocale);
        $translations = $this->getTranslations($currentLocale);

        return view('theme::admin.theme-translate.index', compact('currentLocale', 'translations', 'origins'));
    }

    public function save(Request $request)
    {
        $translations = array_filter($request->input('translations'));
        $edit_locale = $request->input('edit_locale');

        $path = lang_path("{$edit_locale}.json");

        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put(
            $path,
            json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $setting_key = 'theme_translate_'.$edit_locale;
        setting()->set($setting_key, json_encode($translations, JSON_UNESCAPED_UNICODE));

        return back()->with('success', __('theme::theme-translate.notification.updated'));
    }

    private function getOrigins(string $currentLocale)
    {
        $path = Theme::path("lang/{$currentLocale}.json");
        $translations = [];
        if (File::exists($path)) {
            $translations = json_decode(File::get($path), true);
        }
        return $translations;
    }

    private function getTranslations(string $currentLocale)
    {
        $path = lang_path("{$currentLocale}.json");
        $translations = [];
        if (File::exists($path)) {
            $translations = json_decode(File::get($path), true);
        }
        return $translations;
    }
}
