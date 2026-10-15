<?php

declare(strict_types=1);

namespace SushiMarket\JobContextLogger;

use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class JobContextLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/job-context-logger.php',
            'job-context-logger',
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/job-context-logger.php' => config_path('job-context-logger.php'),
        ], 'job-context-logger-config');

        if (! config('job-context-logger.enabled', true)) {
            return;
        }

        $contextKey = (string) config('job-context-logger.context_key', 'job');

        Queue::before(static function (JobProcessing $event) use ($contextKey): void {
            Context::add($contextKey, [
                'name' => $event->job->resolveName(),
                'uuid' => $event->job->uuid(),
                'connection' => $event->connectionName,
                'queue' => $event->job->getQueue(),
                'attempts' => $event->job->attempts(),
            ]);
        });

        // Clear after success. On failure, keep context available for exception logging.
        Queue::after(static function () use ($contextKey): void {
            Context::forget($contextKey);
        });
    }
}
