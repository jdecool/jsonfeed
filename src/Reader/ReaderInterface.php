<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Reader;

use JDecool\JsonFeed\Feed;

interface ReaderInterface
{
    /**
     * Read feed from JSON
     *
     * @param string $json
     * @return Feed
     *
     * @throws \JDecool\JsonFeed\Exceptions\InvalidFeedException
     */
    public function readFromJson($json);
}
