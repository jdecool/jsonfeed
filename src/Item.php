<?php

namespace JDecool\JsonFeed;

use DateTime;

class Item
{
    /** @var string */
    private $id;

    /** @var string */
    private $url;

    /** @var string */
    private $externalUrl;

    /** @var string */
    private $title;

    /** @var string */
    private $contentHtml;

    /** @var string */
    private $contentText;

    /** @var string */
    private $summary;

    /** @var string */
    private $image;

    /** @var string */
    private $bannerImage;

    /** @var DateTime */
    private $datePublished;

    /** @var DateTime */
    private $dateModified;

    /** @var Author */
    private $author;

    /** @var string[] */
    private $tags;

    /** @var Attachment[] */
    private $attachments;

    /**
     * Constructor
     *
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;

        $this->tags = [];
        $this->attachments = [];
    }

    /**
     * Get unique identifer for that item for that feed over time
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the URL of the resource described by the item
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the URL of the resource described by the item
     *
     * @param string $url
     * @return Item
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the URL of a page elsewhere
     *
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * Set the URL of a page elsewhere
     *
     * @param string $externalUrl
     * @return Item
     */
    public function setExternalUrl($externalUrl)
    {
        $this->externalUrl = $externalUrl;

        return $this;
    }

    /**
     * Get plaintext title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set plaintext title
     *
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the HTML content for the item
     *
     * @return string
     */
    public function getContentHtml()
    {
        return $this->contentHtml;
    }

    /**
     * Set the HTML content for the item
     *
     * @param string $contentHtml
     * @return Item
     */
    public function setContentHtml($contentHtml)
    {
        $this->contentHtml = $contentHtml;

        return $this;
    }

    /**
     * Get plain text content for the item
     *
     * @return string
     */
    public function getContentText()
    {
        return $this->contentText;
    }

    /**
     * Set plain text content for the item
     *
     * @param string $contentText
     * @return Item
     */
    public function setContentText($contentText)
    {
        $this->contentText = $contentText;

        return $this;
    }

    /**
     * Get a plain text sentence or two describing the item
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set a plain text sentence or two describing the item
     *
     * @param string $summary
     * @return Item
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get the URL of the main image for the item
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the URL of the main image for the item
     *
     * @param string $image
     * @return Item
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the URL of an image to use as a banner
     *
     * @return string
     */
    public function getBannerImage()
    {
        return $this->bannerImage;
    }

    /**
     * Set the URL of an image to use as a banner
     *
     * @param string $bannerImage
     * @return Item
     */
    public function setBannerImage($bannerImage)
    {
        $this->bannerImage = $bannerImage;

        return $this;
    }

    /**
     * Get the item published date
     *
     * @return DateTime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

    /**
     * Set the item published date
     *
     * @param DateTime $datePublished
     * @return Item
     */
    public function setDatePublished(DateTime $datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get the item modified date
     *
     * @return DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Set the item modified date
     *
     * @param DateTime $dateModified
     * @return Item
     */
    public function setDateModified(DateTime $dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get item author
     *
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set item author
     *
     * @param Author $author
     * @return Item
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get item tags
     *
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add item tag
     * @param string $tag
     * @return Item
     */
    public function addTag($tag)
    {
        if (!in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    /**
     * Set item tags
     *
     * @param string[] $tags
     * @return Item
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get item attachments
     *
     * @return Attachment[]
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Add item attachment
     *
     * @param Attachment $attachment
     * @return Item
     */
    public function addAttachment(Attachment $attachment)
    {
        if (!in_array($attachment, $this->attachments, true)) {
            $this->attachments[] = $attachment;
        }

        return $this;
    }

    /**
     * Set item attachments
     *
     * @param Attachment[] $attachments
     * @return Item
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }
}
