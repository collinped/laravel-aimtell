<?php

namespace Collinped\Aimtell;

use Collinped\Aimtell\Commands\AimtellPushCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AimtellServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/aimtell.php' => config_path('aimtell.php'),
            ], 'config');

            $this->commands([
                AimtellPushCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aimtell.php', 'aimtell');

        $this->app->singleton(Aimtell::class, function ($app) {
            return new Aimtell($app['config']['aimtell']['api_key'], $app['config']['aimtell']['white_label_id'], $app['config']['aimtell']['default_site_id']);
        });
    }

    public function provides(): array
    {
        return [Aimtell::class];
    }
}
