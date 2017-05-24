<?php

namespace JDecool\JsonFeed\Writer;

use JDecool\JsonFeed\Feed;

interface RendererInterface
{
    /**
     * Render feed as JSON string
     *
     * @param Feed $feed
     * @return string
     */
    public function render(Feed $feed);
}
