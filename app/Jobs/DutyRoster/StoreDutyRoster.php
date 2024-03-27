<?php

namespace App\Jobs\DutyRoster;

use App\DutyRoster\DutyRosterDirectorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreDutyRoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $contentType,
        private readonly string $content,
    )
    {
    }

    public function handle(): void
    {
        $director = $this->determineDirector();

        $data = $director->read($this->content);
        $data =$director->transform($data);

        $director->write($data);
    }

    private function determineDirector(): DutyRosterDirectorInterface
    {

    }
}
