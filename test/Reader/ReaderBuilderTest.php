<?php

namespace JDecool\Test\JsonFeed\Reader;

use JDecool\JsonFeed\Reader\ReaderBuilder;
use PHPUnit\Framework\TestCase;

class ReaderBuilderTest extends TestCase
{
    public function testBuilder()
    {
        $builder = new ReaderBuilder();

        $this->assertInstanceOf('JDecool\JsonFeed\Reader\Reader', $builder->build());
    }
}
