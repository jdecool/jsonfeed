JSONFeed
========

[![Build Status](https://travis-ci.org/jdecool/jsonfeed.svg?branch=master)](https://travis-ci.org/jdecool/jsonfeed)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jdecool/jsonfeed/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jdecool/jsonfeed/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/jdecool/jsonfeed/v/stable.png)](https://packagist.org/packages/jdecool/jsonfeed)

[JSONFeed](https://jsonfeed.org) is a pragmatic syndication format, like RSS and Atom, but with one big difference: 
it’s JSON instead of XML.

This library provides functionnalits for mananaging feed through your PHP code. It provides a natural syntax for accessing
elements of feed.

## Install

Install the library using [composer](https://getcomposer.org):

```json
{
    "require": {
        "jdecool/jsonfeed": "^0.1"
    }
}
```

# Example

Create your feed :

```php
use DateTime;
use DateTimeZone;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Item;

$author = new Author('Brent Simmons');
$author->setUrl('http://example.org/');
$author->setAvatar('https://example.org/avatar.png');

$item = new Item('2347259');
$item->setUrl('https://example.org/2347259');
$item->setDatePublished(new DateTime('2016-02-09 14:22:00', new DateTimeZone('+0200')));
$item->setContentText('Cats are neat. https://example.org/cats');

$feed = new Feed('Brent Simmons’s Microblog');
$feed->setUserComment('This is a microblog feed. You can add this to your feed reader using the following URL: https://example.org/feed.json');
$feed->setHomepageUrl('https://example.org/');
$feed->setFeedUrl('https://example.org/feed.json');
$feed->setAuthor($author);
$feed->addItem($item);

```

Render it :

```php
use JDecool\JsonFeed\Writer\RendererFactory;

$renderer = $factory->createRenderer(RendererFactory::VERSION_1);

header('Content-Type: application/json');
echo $renderer->render($feed);
```

Read a feed :

```php
use JDecool\JsonFeed\Reader\ReaderBuilder;

$json = file_get_content('http://foo.bar');

$reader = (new ReaderBuilder())->build();
$feed = $reader->createFromJson($json);
```
