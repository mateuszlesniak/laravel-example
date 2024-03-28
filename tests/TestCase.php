<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class TestCase extends BaseTestCase
{
    public function prepareCrawler(string $expectedValue): Crawler
    {
        $crawler = $this->createMock(Crawler::class);
        $crawler->method('filter')->willReturn($crawler);
        $crawler->method('first')->willReturn($crawler);
        $crawler->method('text')->willReturn($expectedValue);

        return $crawler;
    }
}
