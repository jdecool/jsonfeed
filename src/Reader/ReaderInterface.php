<?php

namespace JDecool\JsonFeed\Reader;

use JDecool\JsonFeed\Feed;

interface ReaderInterface
{
    /**
     * Read feed from JSON
     *
     * @param string $json
     * @return Feed
     */
    public function readFromJson($json);
}
