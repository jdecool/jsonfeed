<?php

namespace JDecool\JsonFeed\Reader;

use JDecool\JsonFeed\Versions;

class ReaderBuilder
{
    /**
     * Builder a reader
     *
     * @return Reader
     */
    public function build()
    {
        return new Reader([
            Versions::VERSION_1 => Version1\FeedReader::create(),
        ]);
    }
}
