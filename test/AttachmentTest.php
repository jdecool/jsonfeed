<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Attachment;
use PHPUnit\Framework\TestCase;

class AttachmentTest extends TestCase
{
    public function testCreateObject()
    {
        $attachment = new Attachment('file://foo', 'application/bar');

        $this->assertEquals('file://foo', $attachment->getUrl());
        $this->assertEquals('application/bar', $attachment->getMimeType());
        $this->assertNull($attachment->getTitle());
        $this->assertNull($attachment->getSize());
        $this->assertNull($attachment->getDuration());
    }

    public function testFullObject()
    {
        $attachment = new Attachment('file://foo', 'application/bar');
        $attachment
            ->setTitle('My title')
            ->setSize(500)
            ->setDuration(25)
        ;

        $this->assertEquals('file://foo', $attachment->getUrl());
        $this->assertEquals('application/bar', $attachment->getMimeType());
        $this->assertEquals('My title', $attachment->getTitle());
        $this->assertEquals(500, $attachment->getSize());
        $this->assertEquals(25, $attachment->getDuration());
    }
}
