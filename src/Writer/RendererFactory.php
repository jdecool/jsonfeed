<?php

namespace JDecool\JsonFeed\Writer;

use InvalidArgumentException;

class RendererFactory
{
    const VERSION_1 = '1.0';

    /**
     * Create specific renderer
     *
     * @param string $version
     * @return Version1\Renderer
     */
    public function createRenderer($version = self::VERSION_1)
    {
        switch ($version) {
            case self::VERSION_1:
                return new Version1\Renderer();
        }

        throw new InvalidArgumentException(sprintf('Unknow version "%s".', $version));
    }
}
