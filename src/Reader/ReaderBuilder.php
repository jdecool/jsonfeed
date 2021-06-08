<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Reader;

use JDecool\JsonFeed\Versions;

class ReaderBuilder
{
    /**
     * Builder a reader
     *
     * @param bool $isErrorEnabled
     * @return Reader
     */
    public function build($isErrorEnabled = true)
    {
        return new Reader([
            Versions::VERSION_1 => Version1\FeedReader::create($isErrorEnabled),
        ]);
    }
}
