<?php

namespace App\Providers\DutyRoster;

use App\DutyRoster\Dtr\DtrDutyRosterDirector;
use App\DutyRoster\Dtr\Reader\CcnxHtmlReader;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DtrServiceProvider extends ServiceProvider
{
    private const TAG_DTR_READER = 'TAG_DTR_READER';
    private const TAG_DTR_TRANSFORMER = 'TAG_DTR_TRANSFORMER';
    private const TAG_DTR_WRITER = 'TAG_DTR_WRITER';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerDirectors();;
        $this->registerReaders();
        $this->registerTransformers();
        $this->registerWriters();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerDirectors(): void
    {
        $this->app->bind(DtrDutyRosterDirector::class, function (Application $app) {
            return new DtrDutyRosterDirector(
                $app->tagged(self::TAG_DTR_READER),
                $app->tagged(self::TAG_DTR_TRANSFORMER),
                $app->tagged(self::TAG_DTR_WRITER),
            );
        });

        $this->app->bindMethod([StoreDutyRoster::class, 'handle'], function (StoreDutyRoster $job, Application $app) {
            $job->handle([
                DtrDutyRosterDirector::class => $app->make(DtrDutyRosterDirector::class),
            ]);
        });
    }

    private function registerReaders(): void
    {
        $this->app->tag(CcnxHtmlReader::class, self::TAG_DTR_READER);
    }

    private function registerTransformers(): void
    {

    }

    private function registerWriters(): void
    {

    }
}
