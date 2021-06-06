<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Item;
use PHPUnit\Framework\TestCase;

class FeedTest extends TestCase
{
    public function testCreateObject(): void
    {
        $feed = new Feed('My feed');

        static::assertEquals('My feed', $feed->getTitle());
        static::assertNull($feed->getHomepageUrl());
        static::assertNull($feed->getFeedUrl());
        static::assertNull($feed->getDescription());
        static::assertNull($feed->getUserComment());
        static::assertNull($feed->getNextUrl());
        static::assertNull($feed->getIcon());
        static::assertNull($feed->getFavicon());
        static::assertNull($feed->getAuthor());
        static::assertNull($feed->isExpired());
        static::assertEmpty($feed->getHubs());
        static::assertEmpty($feed->getItems());
    }

    public function testFeedWithOneItem(): void
    {
        $item = new Item('itemId');
        $feed = new Feed('My feed');
        $feed->addItem($item);

        $feedItems = $feed->getItems();
        static::assertEquals(1, count($feedItems));
        static::assertEquals($item, $feedItems[0]);
    }

    public function testFeedWithTwoItems(): void
    {
        $item1 = new Item('itemId1');
        $item2 = new Item('itemId2');

        $feed = new Feed('My feed');
        $feed->addItem($item1);
        $feed->addItem($item2);

        $feedItems = $feed->getItems();
        static::assertEquals(2, count($feedItems));
        static::assertEquals($item1, $feedItems[0]);
        static::assertEquals($item2, $feedItems[1]);
    }
}
