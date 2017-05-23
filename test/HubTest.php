<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Hub;
use PHPUnit\Framework\TestCase;

class HubTest extends TestCase
{
    public function testCreateObject()
    {
        $hub = new Hub('foo', 'file://bar');

        $this->assertEquals('foo', $hub->getType());
        $this->assertEquals('file://bar', $hub->getUrl());
    }
}
