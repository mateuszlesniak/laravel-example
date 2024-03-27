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
use App\Jobs\DutyRoster\StoreDutyRoster;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class DtrServiceProvider extends ServiceProvider
{
    private const TAG_DTR_READER = 'TAG_DTR_READER';
    private const TAG_DTR_TRANSFORMER = 'TAG_DTR_TRANSFORMER';
    private const TAG_DTR_WRITER = 'TAG_DTR_WRITER';

    private const TAG_DTR_HTML_READER_PLUGIN = 'TAG_DTR_HTML_READER_PLUGIN';

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerDirectors();
        $this->registerReaders();
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

        $this->registerHtmlReaderPlugins();
    }

    private function registerHtmlReaderPlugins(): void
    {
        $this->app->tag([
            RosterDtoActivityReaderPlugin::class,
            RosterDtoActivityStartTimeReaderPlugin::class,
            RosterDtoActivityEndTimeReaderPlugin::class,
            RosterDtoDepartureTimeReaderPlugin::class,
            RosterDtoArrivalTimeReaderPlugin::class,
            RosterDtoCheckInLocationReaderPlugin::class,
            RosterDtoCheckOutLocationReaderPlugin::class,
        ], self::TAG_DTR_HTML_READER_PLUGIN);

        $this->app->when(CcnxHtmlReader::class)
            ->needs(ReaderPluginInterface::class)
            ->giveTagged(self::TAG_DTR_HTML_READER_PLUGIN);
    }

    private function registerWriters(): void
    {
        $this->app->tag(DtrDutyRosterWriter::class, self::TAG_DTR_WRITER);
    }
}
