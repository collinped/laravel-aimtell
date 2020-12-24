<?php

namespace Collinped\LaravelAimtell;

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
        $this->setupConfig();

        if ($this->app->runningInConsole()) {
            $this->commands([
                AimtellPushCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton(Aimtell::class, function () {
            return aimtell();
        });

        $this->app->alias('aimtell', Aimtell::class);
    }

    /**
     * Setup config.
     */
    protected function setupConfig(): void
    {
        $source = realpath(__DIR__.'/../config/aimtell.php');

        $this->publishes([$source => config_path('aimtell.php')]);
        $this->mergeConfigFrom($source, 'aimtell');
    }

    public function provides(): array
    {
        return [Aimtell::class];
    }
}
