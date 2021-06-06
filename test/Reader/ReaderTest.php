<?php

namespace JDecool\Test\JsonFeed\Reader;

use JDecool\JsonFeed\Exceptions\InvalidFeedException;
use JDecool\JsonFeed\Exceptions\RuntimeException;
use JDecool\JsonFeed\Reader\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testCreateFromJson(): void
    {
        $json = <<<JSON
{
    "version": "foo",
    "title": "My Example Feed"
}
JSON;

        $feedReader = $this->getMockBuilder('JDecool\JsonFeed\Reader\ReaderInterface')->getMock();
        $feedReader->expects($this->once())
                   ->method('readFromJson');

        $reader = new Reader([
            'foo' => $feedReader,
        ]);

        $reader->createFromJson($json);
    }

    public function testCreateFromJsonWithInvalidReader(): void
    {
        $json = <<<JSON
{
    "version": "foo",
    "title": "My Example Feed"
}
JSON;

        $reader = new Reader([]);

         $this->expectException(RuntimeException::class);
         $this->expectExceptionMessage('No reader registered for version "foo"');

        $reader->createFromJson($json);
    }

    public function testCreateFromJsonWithInvalidString(): void
    {
        $json = <<<JSON
{
    "version": "foo",
    "title": "My Example Feed",
}
JSON;

        $reader = new Reader([]);

         $this->expectException(InvalidFeedException::class);
         $this->expectExceptionMessage('Invalid JSONFeed string');

        $reader->createFromJson($json);
    }

    public function testCreateFromJsonWithoutVersion(): void
    {
        $json = <<<JSON
{
    "title": "My Example Feed"
}
JSON;

        $reader = new Reader([]);

         $this->expectException(InvalidFeedException::class);
         $this->expectExceptionMessage('Undefined JSONFeed version');

        $reader->createFromJson($json);
    }
}
