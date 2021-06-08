<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Writer;

use JDecool\JsonFeed\Exceptions\RuntimeException;
use JDecool\JsonFeed\Versions;

class RendererFactory
{
    /** @var array */
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
     *
     * @throws RuntimeException
     */
    public function createRenderer($version = Versions::VERSION_1)
    {
        if (isset($this->renderers[$version])) {
            return $this->renderers[$version];
        }

        switch ($version) {
            case Versions::VERSION_1:
                return new Version1\Renderer();
        }

        throw RuntimeException::noRendererRegisteredException($version);
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
