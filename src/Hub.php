<?php

namespace JDecool\JsonFeed;

/**
 * A hub describes endpoints that can be used to subscribe to real-time notifications from the publisher of this feed.
 * Each object has a `type` and `url`, both of which are required.
 */
class Hub
{
    /** @var string */
    private $type;

    /** @var string */
    private $url;

    /**
     * Constructor
     *
     * @param string $type
     * @param string $url
     */
    public function __construct($type, $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * Get hub type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get hub URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
