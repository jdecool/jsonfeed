<?php

declare(strict_types=1);

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Hub;
use PHPUnit\Framework\TestCase;

class HubTest extends TestCase
{
    public function testCreateObject(): void
    {
        $hub = new Hub('foo', 'file://bar');

        static::assertEquals('foo', $hub->getType());
        static::assertEquals('file://bar', $hub->getUrl());
    }
}
