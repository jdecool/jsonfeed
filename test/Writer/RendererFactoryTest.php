<?php

namespace JDecool\Test\JsonFeed\Writer;

use JDecool\JsonFeed\Writer\RendererFactory;
use PHPUnit\Framework\TestCase;

class RendererFactoryTest extends TestCase
{
    public function testCreateDefaultRenderer()
    {
        $factory = new RendererFactory();

        $renderer = $factory->createRenderer();
        $this->assertInstanceOf('JDecool\JsonFeed\Writer\Version1\Renderer', $renderer);
    }

    public function testCreateVersion1Renderer()
    {
        $factory = new RendererFactory();

        $renderer = $factory->createRenderer(RendererFactory::VERSION_1);
        $this->assertInstanceOf('JDecool\JsonFeed\Writer\Version1\Renderer', $renderer);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Unknow version "foo".
     */
    public function testCreateWrongVersionRenderer()
    {
        $factory = new RendererFactory();
        $factory->createRenderer('foo');
    }
}
