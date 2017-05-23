<?php

namespace JDecool\Test\JsonFeed;

use JDecool\JsonFeed\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testCreateObject()
    {
        $author = new Author('foo');

        $this->assertEquals('foo', $author->getName());
        $this->assertNull($author->getUrl());
        $this->assertNull($author->getAvatar());
    }

    public function testFullObject()
    {
        $author = new Author('foo');
        $author
            ->setUrl('file://bar')
            ->setAvatar('file://image')
        ;

        $this->assertEquals('foo', $author->getName());
        $this->assertEquals('file://bar', $author->getUrl());
        $this->assertEquals('file://image', $author->getAvatar());
    }
}
