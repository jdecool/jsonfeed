<?php

namespace JDecool\JsonFeed;

/**
 * Specifies the feed author
 */
class Author
{
    /** @var string */
    private $name;

    /** @var string */
    private $url;

    /** @var string */
    private $avatar;

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the author’s name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the URL of a site owned by the author
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the URL of a site owned by the author
     *
     * @param string $url
     * @return Author
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the URL for an image for the author
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the URL for an image for the author
     *
     * @param string $avatar
     * @return Author
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
}
