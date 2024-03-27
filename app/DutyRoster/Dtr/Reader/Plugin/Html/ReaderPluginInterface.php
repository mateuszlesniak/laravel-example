<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use App\DutyRoster\Shared\Dto\RosterDto;
use Symfony\Component\DomCrawler\Crawler;

interface ReaderPluginInterface
{
    public function fillRosterDto(Crawler $roster, RosterDto $rosterDto): void;
}
