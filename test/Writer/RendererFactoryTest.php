<?php

namespace JDecool\Test\JsonFeed\Writer;

use JDecool\JsonFeed\Exceptions\RuntimeException;
use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Versions;
use JDecool\JsonFeed\Writer\RendererFactory;
use PHPUnit\Framework\TestCase;

class RendererFactoryTest extends TestCase
{
    public function testCreateDefaultRenderer(): void
    {
        $factory = new RendererFactory();

        $renderer = $factory->createRenderer();
        static::assertInstanceOf('JDecool\JsonFeed\Writer\Version1\Renderer', $renderer);
    }

    public function testCreateVersion1Renderer(): void
    {
        $factory = new RendererFactory();

        $renderer = $factory->createRenderer(Versions::VERSION_1);
        static::assertInstanceOf('JDecool\JsonFeed\Writer\Version1\Renderer', $renderer);
    }

    public function testCreateWrongVersionRenderer(): void
    {
        $factory = new RendererFactory();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No renderer registered for version "foo"');

        $factory->createRenderer('foo');
    }

    public function testRegisterCustomProvider(): void
    {
        $customRenderer =  $this->getMockBuilder('JDecool\JsonFeed\Writer\RendererInterface')->getMock();
        $customRenderer->method('render')
            ->willReturn('custom render')
        ;

        $factory = new RendererFactory();
        $factory->registerRenderer('custom', $customRenderer);

        $renderer = $factory->createRenderer('custom');
        static::assertEquals('custom render', $renderer->render(new Feed('My feed')));
    }
}
