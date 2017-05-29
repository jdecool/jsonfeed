<?php

namespace JDecool\Test\JsonFeed\Reader;

use JDecool\JsonFeed\Reader\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testCreateFromJson()
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

    /**
     * @expectedException JDecool\JsonFeed\Exceptions\RuntimeException
     * @expectedExceptionMessage No reader registered for version "foo"
     */
    public function testCreateFromJsonWithInvalidReader()
    {
        $json = <<<JSON
{
    "version": "foo",
    "title": "My Example Feed"
}
JSON;

        $reader = new Reader([]);
        $reader->createFromJson($json);
    }

    /**
     * @expectedException JDecool\JsonFeed\Exceptions\InvalidFeedException
     * @expectedExceptionMessage Invalid JSONFeed string
     */
    public function testCreateFromJsonWithInvalidString()
    {
        $json = <<<JSON
{
    "version": "foo",
    "title": "My Example Feed",
}
JSON;

        $reader = new Reader([]);
        $reader->createFromJson($json);
    }

    /**
     * @expectedException JDecool\JsonFeed\Exceptions\InvalidFeedException
     * @expectedExceptionMessage Undefined JSONFeed version
     */
    public function testCreateFromJsonWithoutVersion()
    {
        $json = <<<JSON
{
    "title": "My Example Feed"
}
JSON;

        $reader = new Reader([]);
        $reader->createFromJson($json);
    }
}
