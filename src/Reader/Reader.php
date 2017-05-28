<?php

namespace JDecool\JsonFeed\Reader;

use InvalidArgumentException;
use RuntimeException;

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
     */
    public function createFromJson($json)
    {
        $content = json_decode($json, true);
        if (!is_array($content)) {
            throw new InvalidArgumentException('Invalid JSONFeed string');
        }

        if (!isset($content['version'])) {
            throw new RuntimeException('JSONFeed version is not defined');
        }

        if (!isset($this->readers[$content['version']])) {
            throw new RuntimeException(sprintf('No reader for version "%s"', $content['version']));
        }

        return $this->readers[$content['version']]->readFromJson($json);
    }
}
