<?php

namespace App\Providers\DutyRoster;

use App\DutyRoster\Dtr\DtrDutyRosterDirector;
use App\DutyRoster\Dtr\Reader\CcnxHtmlReader;
use App\DutyRoster\Dtr\Reader\Plugin\Html\ReaderPluginInterface;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityEndTimeReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoActivityStartTimeReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoArrivalTimeReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoCheckInLocationReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoCheckOutLocationReaderPlugin;
use App\DutyRoster\Dtr\Reader\Plugin\Html\RosterDtoDepartureTimeReaderPlugin;
use App\DutyRoster\Dtr\Writer\DtrDutyRosterWriter;
use App\DutyRoster\Repository\RosterRepository;
use App\DutyRoster\Repository\RosterRepositoryInterface;
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DutyRosterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $this->app->bind(RosterRepositoryInterface::class,RosterRepository::class);
    }
}
