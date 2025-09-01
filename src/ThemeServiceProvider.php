<?php

namespace Newnet\Theme;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\File;
use Newnet\Module\Support\BaseModuleServiceProvider;
use Newnet\Theme\Console\Commands\ThemeInstallCommand;
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

        $this->activateTheme();
    }

    public function boot()
    {
        parent::boot();

        $this->commands([
            ThemeLinkCommand::class,
            ThemeCreateCommand::class,
            ThemeInstallCommand::class,
        ]);

        // MaintenanceMode
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', MaintenanceMode::class);
    }

    protected function registerThemeConfig()
    {
        $configViewPaths = config('view.paths');
        $configViewPaths[] = realpath(__DIR__.'/../resources/theme-default');
        $this->app['config']->set('view.paths', $configViewPaths);
    }

    protected function activateTheme()
    {
        $theme = config('cms.theme.current_theme');
        if ($theme) {
            $theme_composer_path = public_path("themes/{$theme}/composer.json");
            $root_composer_path = base_path('composer.json');
            if (File::exists($theme_composer_path) && File::exists($root_composer_path)) {
                $theme_composer = File::json($theme_composer_path);
                $root_composer = File::json($root_composer_path);
                $theme_composer_name = $theme_composer['name'];
                $root_composer_require = $root_composer['require'];

                if (!isset($root_composer_require[$theme_composer_name])) {
                    // Active Theme
                    Theme::set($theme);

                    // Register Autoloader
                    $composerLoader = new ClassLoader();
                    $namespaces = $theme_composer['autoload']['psr-4'] ?? [];
                    foreach ($namespaces as $name => $src) {
                        $composerLoader->setPsr4($name, Theme::path($src));
                    }
                    $composerLoader->register();

                    // Register Provider
                    $providers = $theme_composer['extra']['laravel']['providers'] ?? [];
                    foreach ($providers as $provider) {
                        if (class_exists($provider)) {
                            $this->app->register($provider);
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
