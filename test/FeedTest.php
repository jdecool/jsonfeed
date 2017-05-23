<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Item;
use PHPUnit\Framework\TestCase;

class FeedTest extends TestCase
{
    public function testCreateObject()
    {
        $feed = new Feed('My feed');

        $this->assertEquals('My feed', $feed->getTitle());
        $this->assertNull($feed->getHomepageUrl());
        $this->assertNull($feed->getFeedUrl());
        $this->assertNull($feed->getDescription());
        $this->assertNull($feed->getUserComment());
        $this->assertNull($feed->getNextUrl());
        $this->assertNull($feed->getIcon());
        $this->assertNull($feed->getFavicon());
        $this->assertNull($feed->getAuthor());
        $this->assertNull($feed->isExpired());
        $this->assertEmpty($feed->getHubs());
        $this->assertEmpty($feed->getItems());
    }

    public function testFeedWithOneItem()
    {
        $item = new Item('itemId');
        $feed = new Feed('My feed');
        $feed->addItem($item);

        $feedItems = $feed->getItems();
        $this->assertEquals(1, count($feedItems));
        $this->assertEquals($item, $feedItems[0]);
    }

    public function testFeedWithTwoItems()
    {
        $item1 = new Item('itemId1');
        $item2 = new Item('itemId2');

        $feed = new Feed('My feed');
        $feed->addItem($item1);
        $feed->addItem($item2);

        $feedItems = $feed->getItems();
        $this->assertEquals(2, count($feedItems));
        $this->assertEquals($item1, $feedItems[0]);
        $this->assertEquals($item2, $feedItems[1]);
    }
}
