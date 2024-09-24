<?php

namespace Newnet\Theme;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\File;
use MCStreetguy\ComposerParser\Factory as ComposerParser;
use Newnet\Module\Support\BaseModuleServiceProvider;
use Newnet\Theme\Console\Commands\ThemeLinkCommand;
use Newnet\Theme\Console\Commands\ThemeCreateCommand;
use Newnet\Theme\Facades\Theme;
use Newnet\Theme\Http\Middleware\MaintenanceMode;

class ThemeServiceProvider extends BaseModuleServiceProvider
{
    public function register()
    {
        parent::register();

        require_once __DIR__.'/../helpers/helpers.php';

        $this->registerThemeConfig();

        $this->registerThemeFinder();
    }

    public function boot()
    {
        parent::boot();

        $this->activateTheme();

        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeLinkCommand::class,
                ThemeCreateCommand::class,
            ]);
        }

        // MaintenanceMode
        if (setting('maintenance_enabled')) {
            $router = $this->app['router'];
            $router->pushMiddlewareToGroup('web', MaintenanceMode::class);
        }
    }

    protected function registerThemeConfig()
    {
        $configViewPaths = config('view.paths');
        $configViewPaths[] = realpath(__DIR__.'/../resources/theme-default');
        $this->app['config']->set('view.paths', $configViewPaths);
    }

    protected function activateTheme()
    {
        $theme = config('cms.theme.current_theme') ?: setting('theme_name');
        if ($theme) {
            $theme_composer_path = public_path("themes/{$theme}/composer.json");
            $root_composer_path = base_path('composer.json');
            if (File::exists($theme_composer_path) && File::exists($root_composer_path)) {
                $theme_composer = ComposerParser::parse($theme_composer_path);
                $root_composer = ComposerParser::parse($root_composer_path);
                $theme_composer_name = $theme_composer->getName();
                $root_composer_require = $root_composer->getRequire();

                if (!isset($root_composer_require[$theme_composer_name])) {
                    // Active Theme
                    Theme::set($theme);

                    // Autoloader
                    $composerLoader = new ClassLoader();
                    $namespaces = $theme_composer->getAutoload()->getPsr4()->getNamespaces();
                    foreach ($namespaces as $val) {
                        $composerLoader->setPsr4($val['namespace'], Theme::path($val['source']));
                    }
                    $composerLoader->register();

                    $extra = $theme_composer->getExtra();
                    if (isset($extra['laravel']['providers'])) {
                        foreach ($extra['laravel']['providers'] as $provider) {
                            if (class_exists($provider)) {
                                $this->app->register($provider);
                            }
                        }
                    }
                }
            }
        }
    }

    protected function registerThemeFinder(): void
    {
        $this->app->singleton('theme.finder', function ($app) {
            $themeFinder = new ThemeViewFinder(
                $app['files'],
                $app['config']['view.paths'],
            );

            $themeFinder->setHints(
                $this->app->make('view')->getFinder()->getHints()
            );

            return $themeFinder;
        });

        $this->app->singleton('theme.manager', ThemeManager::class);
    }
}
