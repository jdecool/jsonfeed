<?php

namespace JDecool\Test\JsonFeed\Writer;

use JDecool\JsonFeed\Feed;
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

    public function testRegisterCustomProvider()
    {
        $customRenderer =  $this->getMockBuilder('JDecool\JsonFeed\Writer\RendererInterface')->getMock();
        $customRenderer->method('render')
            ->willReturn('custom render')
        ;

        $factory = new RendererFactory();
        $factory->registerRenderer('custom', $customRenderer);

        $renderer = $factory->createRenderer('custom');
        $this->assertEquals('custom render', $renderer->render(new Feed('My feed')));
    }
}
