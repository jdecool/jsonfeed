Read a feed
===========

Read a feed is very simple. You just need to create a `Reader` which will parse
the JSONFeed data and will return a `Feed` object.

```php
$json = file_get_content('http://foo/bar');

$builder = JDecool\JsonFeed\Reader\ReaderBuilder();
$reader = $builder->build();

$feed = $reader->createFromJson($json); // Will be a JDecool\JsonFeed\Feed object
```

The `ReaderBuilder::build` method access a boolean as parameter to define if the
parse will through an exception if an error is detected (default value is `true`).
