<?php

namespace Newnet\Theme\Console\Commands;

use Illuminate\Console\Command;
use Newnet\Theme\Generators\ThemeGenerator;

class CreateThemeCommand extends Command
{
    protected $signature = 'cms:create-theme {name?}';

    protected $description = 'Create a new theme';

    public function handle()
    {
        $name = $this->askForName();

        app(ThemeGenerator::class)
            ->setThemeName($name)
            ->setConsole($this)
            ->generate();
    }

    protected function askForName()
    {
        if ($name = $this->argument('name')) {
            return $name;
        }

        do {
            $name = $this->ask('Enter Theme Name');
            if ($name == '') {
                $this->error('Name is required');
            }
        } while (!$name);

        return $name;
    }
}
