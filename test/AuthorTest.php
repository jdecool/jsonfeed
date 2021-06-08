<?php

declare(strict_types=1);

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testCreateObject(): void
    {
        $author = new Author('foo');

        static::assertEquals('foo', $author->getName());
        static::assertNull($author->getUrl());
        static::assertNull($author->getAvatar());
    }

    public function testFullObject(): void
    {
        $author = new Author('foo');
        $author
            ->setUrl('file://bar')
            ->setAvatar('file://image')
        ;

        static::assertEquals('foo', $author->getName());
        static::assertEquals('file://bar', $author->getUrl());
        static::assertEquals('file://image', $author->getAvatar());
    }
}
