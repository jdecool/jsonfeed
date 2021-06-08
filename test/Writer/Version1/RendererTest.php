<?php

declare(strict_types=1);

namespace JDecool\Test\JsonFeed\Writer\Version1;

use DateTime;
use DateTimeZone;
use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Item;
use JDecool\JsonFeed\Writer\Version1\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private static $fixturesPath;

    public static function setUpBeforeClass(): void
    {
        self::$fixturesPath = realpath(__DIR__.'/../../Fixtures');
    }

    public function testSimpleFeed(): void
    {
        $feed = new Feed('My Example Feed');
        $feed->setHomepageUrl('https://example.org/');
        $feed->setFeedUrl('https://example.org/feed.json');

        $item2 = new Item('2');
        $item2->setContentText('This is a second item.');
        $item2->setUrl('https://example.org/second-item');
        $feed->addItem($item2);

        $item1 = new Item('1');
        $item1->setContentHtml('<p>Hello, world!</p>');
        $item1->setUrl('https://example.org/initial-post');
        $feed->addItem($item1);

        $expected = $this->getFixtures('simple');

        $render = new Renderer();
        static::assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testPodcastFeed(): void
    {
        $attachment = new Attachment('http://therecord.co/downloads/The-Record-sp1e1-ChrisParrish.m4a', 'audio/x-m4a');
        $attachment->setSize(89970236);
        $attachment->setDuration(6629);

        $item = new Item('http://therecord.co/chris-parrish');
        $item->setTitle('Special #1 - Chris Parrish');
        $item->setUrl('http://therecord.co/chris-parrish');
        $item->setContentHtml('Chris has worked at <a href="http://adobe.com/">Adobe</a> and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped <a href="http://aged-and-distilled.com/napkin/">Napkin</a>, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on <a href="http://www.ci.bainbridge-isl.wa.us/">Bainbridge Island</a>, a quick ferry ride from Seattle.');
        $item->setContentText('Chris has worked at Adobe and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped Napkin, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on Bainbridge Island, a quick ferry ride from Seattle.');
        $item->setSummary('Brent interviews Chris Parrish, co-host of The Record and one-half of Aged & Distilled.');
        $item->setDatePublished(new DateTime('2014-05-09 14:04:00', new DateTimeZone('Etc/GMT+7')));
        $item->addAttachment($attachment);

        $feed = new Feed('The Record');
        $feed->setUserComment('This is a podcast feed. You can add this feed to your podcast client using the following URL: http://therecord.co/feed.json');
        $feed->setHomepageUrl('http://therecord.co/');
        $feed->setFeedUrl('http://therecord.co/feed.json');
        $feed->addItem($item);

        $expected = $this->getFixtures('podcast');

        $render = new Renderer();
        static::assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testMicroblogFeed(): void
    {
        $author = new Author('Brent Simmons');
        $author->setUrl('http://example.org/');
        $author->setAvatar('https://example.org/avatar.png');

        $item = new Item('2347259');
        $item->setUrl('https://example.org/2347259');
        $item->setDatePublished(new DateTime('2016-02-09 14:22:00', new DateTimeZone('Etc/GMT-2')));
        $item->setContentText('Cats are neat. https://example.org/cats');

        $feed = new Feed('Brent Simmons’s Microblog');
        $feed->setUserComment('This is a microblog feed. You can add this to your feed reader using the following URL: https://example.org/feed.json');
        $feed->setHomepageUrl('https://example.org/');
        $feed->setFeedUrl('https://example.org/feed.json');
        $feed->setAuthor($author);
        $feed->addItem($item);

        $expected = $this->getFixtures('microblog');

        $render = new Renderer();
        static::assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testAuthorsFeed(): void
    {
        $feedAuthor = new Author('Global Author');
        $feed = new Feed('My Example Feed');
        $feed->setFeedUrl('https://example.org/feed.json');
        $feed->setAuthor($feedAuthor);

        $item2Author = new Author('Author 2');
        $item2 = new Item('2');
        $item2->setUrl('https://example.org/2');
        $item2->setContentText('This is a second item.');
        $item2->setAuthor($item2Author);
        $feed->addItem($item2);

        $item1Author = new Author('Author 1');
        $item1 = new Item('1');
        $item1->setUrl('https://example.org/1');
        $item1->setContentHtml('<p>This is the first item.</p>');
        $item1->setAuthor($item1Author);
        $feed->addItem($item1);

        $expected = $this->getFixtures('authors');

        $render = new Renderer();
        static::assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testRenderExtension(): void
    {
        $feed = new Feed('My Example Feed');

        $item2 = new Item('2');
        $item2->setContentText('This is a second item.');
        $item2->setUrl('https://example.org/second-item');
        $item2->addExtension('extItem2', ['foo' => 'value', 'bar' => 'value']);
        $item2->addExtension('extAuthor', ['john' => 'doe', 'jane' => 'doe']);
        $feed->addItem($item2);

        $item1 = new Item('1');
        $item1->setContentHtml('<p>Hello, world!</p>');
        $item1->setUrl('https://example.org/initial-post');
        $item1->addExtension('extAuthor', ['john' => 'doe', 'jane' => 'doe']);
        $feed->addItem($item1);

        $expected = $this->getFixtures('extension');

        $render = new Renderer();
        static::assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    private function getFixtures($name)
    {
        return file_get_contents(self::$fixturesPath.'/'.$name.'.json');
    }
}
