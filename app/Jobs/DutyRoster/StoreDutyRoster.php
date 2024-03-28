<?php

namespace App\Jobs\DutyRoster;

use App\DutyRoster\Dtr\DtrDutyRosterDirector;
use App\DutyRoster\DutyRosterDirectorInterface;
use App\DutyRoster\Shared\Exception\EmptyDataException;
use App\DutyRoster\Shared\Exception\MimeTypeNotSupportedException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreDutyRoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $mimeType,
        private readonly string $content,
    )
    {
    }

    /**
     * @param array|DutyRosterDirectorInterface[] $directors
     *
     * @return void
     *
     * @throws MimeTypeNotSupportedException
     * @throws Exception
     * @throws EmptyDataException
     */
    public function handle(array $directors): void
    {
        $director = $this->determineDirector($directors);

        $director->loadData($this->content, $this->mimeType);
        $director->process();
    }

    /**
     * @param array|DutyRosterDirectorInterface[] $directors
     * @return DutyRosterDirectorInterface
     */
    private function determineDirector(array $directors): DutyRosterDirectorInterface
    {
        return $directors[DtrDutyRosterDirector::class];
    }
}
