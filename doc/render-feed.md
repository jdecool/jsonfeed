Render a feed
=============

To render JSONFeed, you need to create and fill a `Feed` object.

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

After that, you have to choose which renderer will render your feed:

```php
use JDecool\JsonFeed\Writer\RendererFactory;
use JDecool\JsonFeed\Versions;

$factory = new RendererFactory();
$renderer = $factory->createRenderer(Versions::VERSION_1);
```

Finaly render your JSONFeed data:

```php
header('Content-Type: application/json;  charset=UTF-8');
echo $renderer->render($feed);
```
