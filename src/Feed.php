<?php

declare(strict_types=1);

namespace JDecool\JsonFeed;

/**
 * The JSON Feed format is a pragmatic syndication format, like [RSS](http://cyber.harvard.edu/rss/rss.html) and
 * [Atom](https://tools.ietf.org/html/rfc4287), but with one big difference: it’s JSON instead of XML.
 */
class Feed
{
    /** @var string */
    private $title;

    /** @var string */
    private $homepageUrl;

    /** @var string */
    private $feedUrl;

    /** @var string */
    private $description;

    /** @var string */
    private $userComment;

    /** @var string */
    private $nextUrl;

    /** @var string */
    private $icon;

    /** @var string */
    private $favicon;

    /** @var Author */
    private $author;

    /** @var bool */
    private $expired;

    /** @var Hub[] */
    private $hubs;

    /** @var Item[] */
    private $items;

    /**
     * Constructor
     *
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;

        $this->hubs = [];
        $this->items = [];
    }

    /**
     * Get the name of the feed
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the name of the feed
     *
     * @param string $title
     * @return Feed
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the URL of the resource that the feed describes
     *
     * @return string
     */
    public function getHomepageUrl()
    {
        return $this->homepageUrl;
    }

    /**
     * Set the URL of the resource that the feed describes
     *
     * @param string $homepageUrl
     * @return Feed
     */
    public function setHomepageUrl($homepageUrl)
    {
        $this->homepageUrl = $homepageUrl;

        return $this;
    }

    /**
     * Get the URL of the feed, and serves as the unique identifier for the feed
     *
     * @return string
     */
    public function getFeedUrl()
    {
        return $this->feedUrl;
    }

    /**
     * Set the URL of the feed, and serves as the unique identifier for the feed
     *
     * @param string $feedUrl
     * @return Feed
     */
    public function setFeedUrl($feedUrl)
    {
        $this->feedUrl = $feedUrl;

        return $this;
    }

    /**
     * Get more detail, beyond the `title`, on what the feed is about
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set more detail, beyond the `title`, on what the feed is about
     *
     * @param string $description
     * @return Feed
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get a description of the purpose of the feed
     *
     * @return string
     */
    public function getUserComment()
    {
        return $this->userComment;
    }

    /**
     * Set a description of the purpose of the feed
     *
     * @param string $userComment
     * @return Feed
     */
    public function setUserComment($userComment)
    {
        $this->userComment = $userComment;

        return $this;
    }

    /**
     * Get the URL of a feed that provides the next n items, where n is determined by the publisher
     *
     * @return string
     */
    public function getNextUrl()
    {
        return $this->nextUrl;
    }

    /**
     * Set the URL of a feed that provides the next n items, where n is determined by the publisher
     *
     * @param string $nextUrl
     * @return Feed
     */
    public function setNextUrl($nextUrl)
    {
        $this->nextUrl = $nextUrl;

        return $this;
    }

    /**
     * Get the URL of an image for the feed suitable to be used in a timeline, much the way an avatar might be used
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the URL of an image for the feed suitable to be used in a timeline, much the way an avatar might be used
     *
     * @param string $icon
     * @return Feed
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the URL of an image for the feed suitable to be used in a source list
     *
     * @return string
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * Set the URL of an image for the feed suitable to be used in a source list
     *
     * @param string $favicon
     * @return Feed
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;

        return $this;
    }

    /**
     * Get the feed author
     *
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the feed author
     *
     * @param Author $author
     * @return Feed
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Set the feed author
     *
     * @param string $name
     * @param string $url
     * @return Feed
     */
    public function addAuthor($name, $url = null)
    {
        $author = new Author($name);
        $author->setUrl($url);

        return $this->setAuthor($author);
    }

    /**
     * Says whether or not the feed is finished
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * Set the feed has expired
     *
     * @param bool $expired
     * @return Feed
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get endpoints that can be used to subscribe to real-time notifications from the publisher of this feed
     *
     * @return Hub[]
     */
    public function getHubs()
    {
        return $this->hubs;
    }

    /**
     * Add endpoint that can be used to subscribe to real-time notifications from the publisher of this feed
     *
     * @param Hub $hub
     * @return Feed
     */
    public function addHub(Hub $hub)
    {
        if (!in_array($hub, $this->hubs, true)) {
            $this->hubs[] = $hub;
        }

        return $this;
    }

    /**
     * Set endpoints that can be used to subscribe to real-time notifications from the publisher of this feed
     *
     * @param Hub[] $hubs
     * @return Feed
     */
    public function setHubs(array $hubs)
    {
        $this->hubs = $hubs;
        
        return $this;
    }

    /**
     * Get feed items
     *
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add feed item
     *
     * @param Item $item
     * @return Feed
     */
    public function addItem(Item $item)
    {
        if (!in_array($item, $this->items, true)) {
            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * Set feed items
     *
     * @param Item[] $items
     * @return Feed
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
