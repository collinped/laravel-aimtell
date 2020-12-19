<?php

namespace Collinped\LaravelAimtell;

use Collinped\Aimtell\Aimtell;
use Collinped\LaravelAimtell\Commands\AimtellPushCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AimtellServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     */
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

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aimtell.php', 'aimtell');

        $this->app->singleton(Aimtell::class, function() {
            return aimtell();
        });

        $this->app->alias('aimtell', Aimtell::class);
    }

    public function provides(): array
    {
        return [Aimtell::class];
    }
}
