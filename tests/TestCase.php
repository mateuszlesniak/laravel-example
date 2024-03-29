<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class TestCase extends BaseTestCase
{
    protected function prepareCrawler(string $expectedValue = ''): Crawler
    {
        $crawler = $this->createMock(Crawler::class);
        $crawler->method('filter')->willReturn($crawler);
        $crawler->method('first')->willReturn($crawler);
        $crawler->method('text')->willReturn($expectedValue);

        return $crawler;
    }

    protected function getDtrHtmlRoster(): string
    {
        return file_get_contents(__DIR__ . '/Unit/DutyRoster/_data/dtr_html_example.html');
    }

}
