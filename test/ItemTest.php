<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCreateObject()
    {
        $item = new Item('myid');

        $this->assertEquals('myid', $item->getId());
        $this->assertNull($item->getUrl());
        $this->assertNull($item->getExternalUrl());
        $this->assertNull($item->getTitle());
        $this->assertNull($item->getContentHtml());
        $this->assertNull($item->getContentText());
        $this->assertNull($item->getSummary());
        $this->assertNull($item->getImage());
        $this->assertNull($item->getBannerImage());
        $this->assertNull($item->getDatePublished());
        $this->assertNull($item->getDateModified());
        $this->assertEmpty($item->getAuthor());
        $this->assertEmpty($item->getTags());
        $this->assertEmpty($item->getAttachments());
    }

    public function testAddAuthor()
    {
        $author = new Author('foo');

        $item = new Item('myid');
        $item->setAuthor($author);

        $this->assertEquals($author, $item->getAuthor());
    }

    public function testTagsEmpty()
    {
        $item = new Item('myid');
        $this->assertEmpty($item->getTags());
    }

    public function testAddTagsOneElement()
    {
        $item = new Item('myid');
        $item->addTag('tag1');

        $this->assertEquals(1, count($item->getTags()));
        $this->assertEquals(['tag1'], $item->getTags());
    }

    public function testAddTagsTwoElements()
    {
        $item = new Item('myid');
        $item->addTag('tag1');
        $item->addTag('tag2');

        $this->assertEquals(2, count($item->getTags()));
        $this->assertEquals(['tag1', 'tag2'], $item->getTags());
    }

    public function testSetTags()
    {
        $tags = ['tag1', 'tag2'];

        $item = new Item('myid');
        $item->setTags($tags);

        $this->assertEquals($tags, $item->getTags());
    }

    public function testAttachmentEmpty()
    {
        $item = new Item('myid');
        $this->assertEmpty($item->getAttachments());
    }

    public function testAddAttachmentOneElement()
    {
        $attachment = new Attachment('foo1', 'bar1');

        $item = new Item('myid');
        $item->addAttachment($attachment);

        $this->assertEquals(1, count($item->getAttachments()));
        $this->assertEquals([$attachment], $item->getAttachments());
    }

    public function testAddAttachmentTwoElements()
    {
        $attachment1 = new Attachment('foo1', 'bar1');
        $attachment2 = new Attachment('foo2', 'bar2');

        $item = new Item('myid');
        $item->addAttachment($attachment1);
        $item->addAttachment($attachment2);

        $this->assertEquals(2, count($item->getAttachments()));
        $this->assertEquals([$attachment1, $attachment2], $item->getAttachments());
    }

    public function testSetAttachments()
    {
        $attachments = [
            new Attachment('foo1', 'bar1'),
            new Attachment('foo2', 'bar2'),
        ];

        $item = new Item('myid');
        $item->setAttachments($attachments);

        $this->assertEquals(2, count($item->getAttachments()));
        $this->assertEquals($attachments, $item->getAttachments());
    }
}
