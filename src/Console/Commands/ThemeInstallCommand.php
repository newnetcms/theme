<?php

namespace Newnet\Theme\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Newnet\Theme\Facades\Theme;

class ThemeInstallCommand extends Command
{
    protected $signature = 'cms:theme.install';

    protected $description = 'Install Current Theme';

    public function handle()
    {
        $theme_composer_file = Theme::path('composer.json');
        if (File::exists($theme_composer_file)) {
            $theme_composer = json_decode(File::get($theme_composer_file));
            if (isset($theme_composer->extra->theme->setup)) {
                $class_setup = $theme_composer->extra->theme->setup;
                if (class_exists($class_setup)) {
                    $setup = new $class_setup;
                    $setup->install();
                }
            }
        }
    }
}
