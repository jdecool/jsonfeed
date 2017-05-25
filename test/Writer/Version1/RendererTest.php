<?php

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
    public function testSimpleFeed()
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

        $expected = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "title": "My Example Feed",
    "home_page_url": "https://example.org/",
    "feed_url": "https://example.org/feed.json",
    "items": [
        {
            "id": "2",
            "content_text": "This is a second item.",
            "url": "https://example.org/second-item"
        },
        {
            "id": "1",
            "content_html": "<p>Hello, world!</p>",
            "url": "https://example.org/initial-post"
        }
    ]
}
JSON;

        $render = new Renderer();
        $this->assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testPodcastFeed()
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

        $expected = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "user_comment": "This is a podcast feed. You can add this feed to your podcast client using the following URL: http://therecord.co/feed.json",
    "title": "The Record",
    "home_page_url": "http://therecord.co/",
    "feed_url": "http://therecord.co/feed.json",
    "items": [
        {
            "id": "http://therecord.co/chris-parrish",
            "title": "Special #1 - Chris Parrish",
            "url": "http://therecord.co/chris-parrish",
            "content_text": "Chris has worked at Adobe and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped Napkin, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on Bainbridge Island, a quick ferry ride from Seattle.",
            "content_html": "Chris has worked at <a href=\"http://adobe.com/\">Adobe</a> and as a founder of Rogue Sheep, which won an Apple Design Award for Postage. Chris’s new company is Aged & Distilled with Guy English — which shipped <a href=\"http://aged-and-distilled.com/napkin/\">Napkin</a>, a Mac app for visual collaboration. Chris is also the co-host of The Record. He lives on <a href=\"http://www.ci.bainbridge-isl.wa.us/\">Bainbridge Island</a>, a quick ferry ride from Seattle.",
            "summary": "Brent interviews Chris Parrish, co-host of The Record and one-half of Aged & Distilled.",
            "date_published": "2014-05-09T14:04:00-07:00",
            "attachments": [
                {
                    "url": "http://therecord.co/downloads/The-Record-sp1e1-ChrisParrish.m4a",
                    "mime_type": "audio/x-m4a",
                    "size_in_bytes": 89970236,
                    "duration_in_seconds": 6629
                }
            ]
        }
    ]
}
JSON;

        $render = new Renderer();
        $this->assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }

    public function testMicroblogFeed()
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

        $expected = <<<JSON
{
    "version": "https://jsonfeed.org/version/1",
    "user_comment": "This is a microblog feed. You can add this to your feed reader using the following URL: https://example.org/feed.json",
    "title": "Brent Simmons’s Microblog",
    "home_page_url": "https://example.org/",
    "feed_url": "https://example.org/feed.json",
    "author": {
        "name": "Brent Simmons",
        "url": "http://example.org/",
        "avatar": "https://example.org/avatar.png"
    },
    "items": [
        {
            "id": "2347259",
            "url": "https://example.org/2347259",
            "content_text": "Cats are neat. https://example.org/cats",
            "date_published": "2016-02-09T14:22:00+02:00"
        }
    ]
}
JSON;

        $render = new Renderer();
        $this->assertJsonStringEqualsJsonString($expected, $render->render($feed));
    }
}
