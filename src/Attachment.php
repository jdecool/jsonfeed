<?php

namespace JDecool\JsonFeed;

/**
 * Related resources. Podcasts, for instance, would include an attachment that’s an audio or video file
 */
class Attachment
{
    /** @var string */
    private $url;

    /** @var string */
    private $mimeType;

    /** @var string */
    private $title;

    /** @var int|float */
    private $size;

    /** @var int|float */
    private $duration;

    /**
     * Constructor
     *
     * @param string $url
     * @param string $mimeType
     */
    public function __construct($url, $mimeType)
    {
        $this->url = $url;
        $this->mimeType = $mimeType;
    }

    /**
     * Get the location of the attachment
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the type of the attachment
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Get the name for the attachment
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the name of the attachment
     *
     * @param string $title
     * @return Attachment
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the size of content
     *
     * @return float|int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the size of content
     *
     * @param float|int $size
     * @return Attachment
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the duration of the attachment
     *
     * @return float|int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Specifies how long the attachment takes to listen to or watch
     *
     * @param float|int $duration
     * @return Attachment
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }
}
