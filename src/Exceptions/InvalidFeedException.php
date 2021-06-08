<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Exceptions;

use Exception;

class InvalidFeedException extends Exception
{
    /**
     * @return InvalidFeedException
     */
    public static function invalidJsonException()
    {
        return new self('Invalid JSONFeed string');
    }

    /**
     * @return InvalidFeedException
     */
    public static function undefinedVersionException()
    {
        return new self('Undefined JSONFeed version');
    }

    /**
     * @param string $property
     * @return InvalidFeedException
     */
    public static function invalidFeedProperty($property)
    {
        return new self(sprintf('Invalid feed property "%s"', $property));
    }

    /**
     * @param string $property
     * @return InvalidFeedException
     */
    public static function invalidItemProperty($property)
    {
        return new self(sprintf('Invalid item property "%s"', $property));
    }

    /**
     * @param string $property
     * @return InvalidFeedException
     */
    public static function invalidAuthorProperty($property)
    {
        return new self(sprintf('Invalid author property "%s"', $property));
    }
}
