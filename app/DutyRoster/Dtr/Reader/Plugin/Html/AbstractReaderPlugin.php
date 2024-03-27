<?php

namespace App\DutyRoster\Dtr\Reader\Plugin\Html;

use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractReaderPlugin implements ReaderPluginInterface
{
    abstract protected function getSelector(): string;

    protected function getValue(Crawler $roster): string
    {
        $value = $roster->filter($this->getSelector())->first()->text();

        return str_replace(' ', '', $value);
    }
}
