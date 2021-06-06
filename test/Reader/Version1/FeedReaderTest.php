<?php

namespace JDecool\Test\JsonFeed\Reader\Version1;

use DateTime;
use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Exceptions\InvalidFeedException;
use JDecool\JsonFeed\Item;
use JDecool\JsonFeed\Reader\Version1\FeedReader;
use PHPUnit\Framework\TestCase;

class FeedReaderTest extends TestCase
{
    private static $fixturesPath;

    public static function setUpBeforeClass(): void
    {
        self::$fixturesPath = realpath(__DIR__.'/../../Fixtures');
    }

    public function testSimpleFeed(): void
    {
        $input = $this->getFixtures('simple');
        $reader = FeedReader::create();

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('My Example Feed', $feed->getTitle());
        static::assertEquals('https://example.org/', $feed->getHomepageUrl());
        static::assertEquals('https://example.org/feed.json', $feed->getFeedUrl());

        $items = $feed->getItems();
        static::assertCount(2, $items);

        $item2 = new Item('2');
        $item2->setContentText('This is a second item.');
        $item2->setUrl('https://example.org/second-item');
        static::assertEquals($item2, $items[0]);

        $item1 = new Item('1');
        $item1->setContentHtml('<p>Hello, world!</p>');
        $item1->setUrl('https://example.org/initial-post');
        static::assertEquals($item1, $items[1]);
    }

    public function testPodcastFeed(): void
    {
        $input = $this->getFixtures('podcast');
        $reader = FeedReader::create();

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('The Record', $feed->getTitle());
        static::assertEquals('http://therecord.co/', $feed->getHomepageUrl());
        static::assertEquals('http://therecord.co/feed.json', $feed->getFeedUrl());
        static::assertEquals('This is a podcast feed. You can add this feed to your podcast client using the following URL: http://therecord.co/feed.json', $feed->getUserComment());

        $items = $feed->getItems();
        static::assertCount(1, $items);

        $attachment = new Attachment('http://therecord.co/downloads/The-Record-sp1e1-ChrisParrish.m4a', 'audio/x-m4a');
        $attachment->setSize(89970236);
        $attachment->setDuration(6629);

        $item = new Item('http://therecord.co/chris-parrish');
        $item->setTitle('Special #1 - Chris Parrish');
        $item->setUrl('http://therecord.co/chris-parrish');
        $item->setContentText('Chris has worked at Adobe and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped Napkin, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on Bainbridge Island, a quick ferry ride from Seattle.');
        $item->setContentHtml('Chris has worked at <a href="http://adobe.com/">Adobe</a> and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped <a href="http://aged-and-distilled.com/napkin/">Napkin</a>, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on <a href="http://www.ci.bainbridge-isl.wa.us/">Bainbridge Island</a>, a quick ferry ride from Seattle.');
        $item->setSummary('Brent interviews Chris Parrish, co-host of The Record and one-half of Aged & Distilled.');
        $item->setDatePublished(new DateTime('2014-05-09T14:04:00-07:00'));
        $item->addAttachment($attachment);
        static::assertEquals($item, $items[0]);
    }

    public function testMicroblogFeed(): void
    {
        $input = $this->getFixtures('microblog');
        $reader = FeedReader::create();

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('Brent Simmons’s Microblog', $feed->getTitle());
        static::assertEquals('https://example.org/', $feed->getHomepageUrl());
        static::assertEquals('https://example.org/feed.json', $feed->getFeedUrl());
        static::assertEquals('This is a microblog feed. You can add this to your feed reader using the following URL: https://example.org/feed.json', $feed->getUserComment());

        $items = $feed->getItems();
        static::assertCount(1, $items);

        $item = new Item('2347259');
        $item->setUrl('https://example.org/2347259');
        $item->setContentText('Cats are neat. https://example.org/cats');
        $item->setDatePublished(new DateTime('2016-02-09T14:22:00+02:00'));
        static::assertEquals($item, $items[0]);
    }

    public function testAuthorsFeed(): void
    {
        $input = $this->getFixtures('authors');
        $reader = FeedReader::create();

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('My Example Feed', $feed->getTitle());
        static::assertEquals('Global Author', $feed->getAuthor()->getName());
        static::assertEquals('https://example.org/feed.json', $feed->getFeedUrl());

        $items = $feed->getItems();
        static::assertCount(2, $items);

        $item2Author = new Author('Author 2');
        $item2 = new Item('2');
        $item2->setUrl('https://example.org/2');
        $item2->setContentText('This is a second item.');
        $item2->setAuthor($item2Author);
        static::assertEquals('Author 2', $item2->getAuthor()->getName());
        static::assertEquals($item2, $items[0]);

        $item1Author = new Author('Author 1');
        $item1 = new Item('1');
        $item1->setUrl('https://example.org/1');
        $item1->setContentHtml('<p>This is the first item.</p>');
        $item1->setAuthor($item1Author);
        static::assertEquals('Author 1', $item1->getAuthor()->getName());
        static::assertEquals($item1, $items[1]);
    }

    public function testReaderWithJsonSyntaxError(): void
    {
        $input = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "Brent Simmons’s Microblog",
}
JSON;

        $reader = FeedReader::create();

        $this->expectException(InvalidFeedException::class);
        $this->expectExceptionMessage('Invalid JSONFeed string');

        $reader->readFromJson($input);
    }

    public function testReaderWithInvalidProperty(): void
    {
        $input = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "Brent Simmons’s Microblog",
    "custom": "My custom property"
}
JSON;

        $reader = FeedReader::create();

        $this->expectException(InvalidFeedException::class);
        $this->expectExceptionMessage('Invalid feed property "custom"');

        $reader->readFromJson($input);
    }

    public function testReaderWithInvalidAuthorProperty(): void
    {
        $input = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "Brent Simmons’s Microblog",
    "author": {
        "name": "Author name",
        "foo": "bar"
    }
}
JSON;

        $reader = FeedReader::create();

         $this->expectException(InvalidFeedException::class);
         $this->expectExceptionMessage('Invalid author property "foo"');

        $reader->readFromJson($input);
    }

    public function testReaderWithInvalidItemProperty(): void
    {
        $input = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "Brent Simmons’s Microblog",
    "items": [
        {
            "id": "2347259",
            "url": "https://example.org/2347259",
            "content_text": "Cats are neat. https://example.org/cats",
            "date_published": "2016-02-09T14:22:00+02:00",
            "foo": "bar"
        }
    ]
}
JSON;

        $reader = FeedReader::create();


        $this->expectException(InvalidFeedException::class);
        $this->expectExceptionMessage('Invalid item property "foo"');

        $reader->readFromJson($input);
    }

    public function testReaderWithInvalidPropertyWithErrorEnabled(): void
    {
        $input = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "Brent Simmons’s Microblog",
    "custom": "My custom property"
}
JSON;

        $reader = FeedReader::create(false);

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('Brent Simmons’s Microblog', $feed->getTitle());
    }

    public function testReadExtensions(): void
    {
        $input = $this->getFixtures('extension');
        $reader = FeedReader::create();

        $feed = $reader->readFromJson($input);
        static::assertInstanceOf('JDecool\JsonFeed\Feed', $feed);
        static::assertEquals('My Example Feed', $feed->getTitle());

        $items = $feed->getItems();
        static::assertCount(2, $items);

        $item = new Item('2');
        $item->setContentText('This is a second item.');
        $item->setUrl('https://example.org/second-item');
        $item->addExtension('extItem2', ['foo' => 'value', 'bar' => 'value']);
        $item->addExtension('extAuthor', ['john' => 'doe', 'jane' => 'doe']);
        static::assertEquals($item, $items[0]);

        $item = new Item('1');
        $item->setContentHtml('<p>Hello, world!</p>');
        $item->setUrl('https://example.org/initial-post');
        $item->addExtension('extAuthor', ['john' => 'doe', 'jane' => 'doe']);
        static::assertEquals($item, $items[1]);
    }

    private function getFixtures($name)
    {
        return file_get_contents(self::$fixturesPath.'/'.$name.'.json');
    }
}
