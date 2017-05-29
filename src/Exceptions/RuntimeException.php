<?php

namespace JDecool\JsonFeed\Exceptions;

use Exception;

class RuntimeException extends Exception
{
    /**
     * @param string $version
     * @return RuntimeException
     */
    public static function noReaderRegisteredException($version)
    {
        return new self(sprintf('No reader registered for version "%s"', $version));
    }

    /**
     * @param string $version
     * @return RuntimeException
     */
    public static function noRendererRegisteredException($version)
    {
        return new self(sprintf('No renderer registered for version "%s"', $version));
    }
}
