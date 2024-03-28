<?php

namespace App\DutyRoster\Dtr;

use App\DutyRoster\DutyRosterReaderInterface;
use App\DutyRoster\DutyRosterWriterInterface;
use App\DutyRoster\Shared\AbstractDirector;
use App\DutyRoster\Shared\DutyRosterMimeTypeEnum;
use App\DutyRoster\Shared\Exception\EmptyDataException;
use App\DutyRoster\Shared\Exception\MimeTypeNotSupportedException;
use Exception;

final class DtrDutyRosterDirector extends AbstractDirector
{
    private string $originalData;
    private string $mimeType;

    /**
     * @param DutyRosterReaderInterface[] $readers
     * @param DutyRosterWriterInterface[] $writers
     */
    public function __construct(
        private readonly iterable $readers,
        private readonly iterable $writers,
    )
    {
    }

    public function loadData(string $data, string $mimeType): void
    {
        if (!$this->checkIfMimeTypeIsSupported($mimeType)) {
            throw new MimeTypeNotSupportedException();
        }

        if (empty($data)) {
            throw new EmptyDataException();
        }

        $this->mimeType = $mimeType;
        $this->originalData = $data;
    }

    private function checkIfMimeTypeIsSupported(string $mimeType): bool
    {
        return $mimeType === DutyRosterMimeTypeEnum::TEXT_HTML->value;
    }

    public function process(): void
    {
        foreach ($this->readers as $reader) {
            if ($reader->isApplicable($this->mimeType)) {
                $activitiesDtoCollection = $reader->read($this->originalData);

                break;
            }

            throw new Exception('Cannot find proper reader for given roster');
        }

        foreach ($this->writers as $writer) {
            $writer->write($activitiesDtoCollection);
        }
    }
}
