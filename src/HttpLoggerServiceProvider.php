<?php

namespace AgeekDev\HttpLogger;

use AgeekDev\HttpLogger\Middlewares\HttpLogger;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class HttpLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/http-logger.php', 'http-logger');
    }

    public function boot(): void
    {
        if ($this->runningUnitTests()) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/http-logger.php' => config_path('http-logger.php'),
            ], 'config');
        }

        $this->app->singleton(LogProfile::class, config('http-logger.log_profile'));
        $this->app->singleton(LogWriter::class, config('http-logger.log_writer'));

        if (config('http-logger.enabled', true)) {
            $this->app[Kernel::class]->pushMiddleware(HttpLogger::class);
        }
    }

    /**
     * Determine if the application is running unit tests.
     */
    protected function runningUnitTests(): bool
    {
        return $this->app->runningInConsole() && $this->app->runningUnitTests();
    }
}
