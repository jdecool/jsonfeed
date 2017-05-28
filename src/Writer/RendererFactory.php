<?php

namespace JDecool\JsonFeed\Writer;

use InvalidArgumentException;

class RendererFactory
{
    const VERSION_1 = '1.0';

    private $renderers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->renderers = [];
    }

    /**
     * Create specific renderer
     *
     * @param string $version
     * @return Version1\Renderer
     */
    public function createRenderer($version = self::VERSION_1)
    {
        if (isset($this->renderers[$version])) {
            return $this->renderers[$version];
        }

        switch ($version) {
            case self::VERSION_1:
                return new Version1\Renderer();
        }

        throw new InvalidArgumentException(sprintf('Unknow version "%s".', $version));
    }

    /**
     * Register a custom renderer
     *
     * @param string $key
     * @param RendererInterface $renderer
     * @return RendererFactory
     */
    public function registerRenderer($key, RendererInterface $renderer)
    {
        $this->renderers[$key] = $renderer;

        return $this;
    }
}
