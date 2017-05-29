<?php

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
}
