<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Attachment;
use PHPUnit\Framework\TestCase;

class AttachmentTest extends TestCase
{
    public function testCreateObject(): void
    {
        $attachment = new Attachment('file://foo', 'application/bar');

        static::assertEquals('file://foo', $attachment->getUrl());
        static::assertEquals('application/bar', $attachment->getMimeType());
        static::assertNull($attachment->getTitle());
        static::assertNull($attachment->getSize());
        static::assertNull($attachment->getDuration());
    }

    public function testFullObject(): void
    {
        $attachment = new Attachment('file://foo', 'application/bar');
        $attachment
            ->setTitle('My title')
            ->setSize(500)
            ->setDuration(25)
        ;

        static::assertEquals('file://foo', $attachment->getUrl());
        static::assertEquals('application/bar', $attachment->getMimeType());
        static::assertEquals('My title', $attachment->getTitle());
        static::assertEquals(500, $attachment->getSize());
        static::assertEquals(25, $attachment->getDuration());
    }
}
