<?php

namespace App\Providers\DutyRoster;

use App\DutyRoster\Dtr\Reader\CcnxHtmlReader;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DtrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
//        $this->app->tag([],'tag');

        $this->app->bindMethod([StoreDutyRoster::class, 'handle'], function (StoreDutyRoster $job, Application $app) {
            $job->handle(
//                $app->tagged()
                $app->make(CcnxHtmlReader::class),
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
