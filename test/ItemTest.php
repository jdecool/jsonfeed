<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testCreateObject(): void
    {
        $item = new Item('myid');

        static::assertEquals('myid', $item->getId());
        static::assertNull($item->getUrl());
        static::assertNull($item->getExternalUrl());
        static::assertNull($item->getTitle());
        static::assertNull($item->getContentHtml());
        static::assertNull($item->getContentText());
        static::assertNull($item->getSummary());
        static::assertNull($item->getImage());
        static::assertNull($item->getBannerImage());
        static::assertNull($item->getDatePublished());
        static::assertNull($item->getDateModified());
        static::assertEmpty($item->getAuthor());
        static::assertEmpty($item->getTags());
        static::assertEmpty($item->getAttachments());
    }

    public function testAddAuthor(): void
    {
        $author = new Author('foo');

        $item = new Item('myid');
        $item->setAuthor($author);

        static::assertEquals($author, $item->getAuthor());
    }

    public function testTagsEmpty(): void
    {
        $item = new Item('myid');
        static::assertEmpty($item->getTags());
    }

    public function testAddTagsOneElement(): void
    {
        $item = new Item('myid');
        $item->addTag('tag1');

        static::assertEquals(1, count($item->getTags()));
        static::assertEquals(['tag1'], $item->getTags());
    }

    public function testAddTagsTwoElements(): void
    {
        $item = new Item('myid');
        $item->addTag('tag1');
        $item->addTag('tag2');

        static::assertEquals(2, count($item->getTags()));
        static::assertEquals(['tag1', 'tag2'], $item->getTags());
    }

    public function testSetTags(): void
    {
        $tags = ['tag1', 'tag2'];

        $item = new Item('myid');
        $item->setTags($tags);

        static::assertEquals($tags, $item->getTags());
    }

    public function testAttachmentEmpty(): void
    {
        $item = new Item('myid');
        static::assertEmpty($item->getAttachments());
    }

    public function testAddAttachmentOneElement(): void
    {
        $attachment = new Attachment('foo1', 'bar1');

        $item = new Item('myid');
        $item->addAttachment($attachment);

        static::assertEquals(1, count($item->getAttachments()));
        static::assertEquals([$attachment], $item->getAttachments());
    }

    public function testAddAttachmentTwoElements(): void
    {
        $attachment1 = new Attachment('foo1', 'bar1');
        $attachment2 = new Attachment('foo2', 'bar2');

        $item = new Item('myid');
        $item->addAttachment($attachment1);
        $item->addAttachment($attachment2);

        static::assertEquals(2, count($item->getAttachments()));
        static::assertEquals([$attachment1, $attachment2], $item->getAttachments());
    }

    public function testSetAttachments(): void
    {
        $attachments = [
            new Attachment('foo1', 'bar1'),
            new Attachment('foo2', 'bar2'),
        ];

        $item = new Item('myid');
        $item->setAttachments($attachments);

        static::assertEquals(2, count($item->getAttachments()));
        static::assertEquals($attachments, $item->getAttachments());
    }

    public function testAddExtension(): void
    {
        $extension1 = [
            'about' => 'https://blueshed-podcasts.com/json-feed-extension-docs',
            'explicit' => false,
            'copyright' => '1948 by George Orwell',
            'owner' => 'Big Brother and the Holding Company',
            'subtitle' => 'All shouting, all the time. Double. Plus. Good.'
        ];

        $item = new Item('myid');
        $item->addExtension('blue_shed', $extension1);

        static::assertEquals(1, count($item->getExtensions()));
        static::assertEquals($extension1, $item->getExtension('blue_shed'));

        $extension2 = [
            'foo1' => 'bar1',
            'foo2' => 'bar2',
        ];
        $item->addExtension('blue_shed2', $extension2);

        static::assertEquals(2, count($item->getExtensions()));
        static::assertEquals($extension1, $item->getExtension('blue_shed'));
        static::assertEquals($extension2, $item->getExtension('blue_shed2'));
    }
}
