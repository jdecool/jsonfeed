<?php

namespace JDecool\Test\JsonFeed\Reader;

use JDecool\JsonFeed\Reader\ReaderBuilder;
use PHPUnit\Framework\TestCase;

class ReaderBuilderTest extends TestCase
{
    public function testBuilder(): void
    {
        $builder = new ReaderBuilder();

        static::assertInstanceOf('JDecool\JsonFeed\Reader\Reader', $builder->build());
    }
}
