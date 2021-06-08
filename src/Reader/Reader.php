<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Reader;

use JDecool\JsonFeed\Exceptions\InvalidFeedException;
use JDecool\JsonFeed\Exceptions\RuntimeException;

class Reader
{
    /** @var ReaderInterface[] */
    private $readers;

    /**
     * Constructor
     *
     * @param ReaderInterface[] $readers
     */
    public function __construct(array $readers)
    {
        $this->readers = $readers;
    }

    /**
     * Read feed from JSON
     *
     * @param string $json
     * @return \JDecool\JsonFeed\Feed
     *
     * @throws InvalidFeedException
     * @throws RuntimeException
     */
    public function createFromJson($json)
    {
        $content = json_decode($json, true);
        if (!is_array($content)) {
            throw InvalidFeedException::invalidJsonException();
        }

        if (!isset($content['version'])) {
            throw InvalidFeedException::undefinedVersionException();
        }

        if (!isset($this->readers[$content['version']])) {
            throw RuntimeException::noReaderRegisteredException($content['version']);
        }

        return $this->readers[$content['version']]->readFromJson($json);
    }
}
