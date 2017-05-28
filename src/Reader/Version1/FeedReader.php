<?php

namespace JDecool\JsonFeed\Reader\Version1;

use DateTime;
use InvalidArgumentException;
use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Hub;
use JDecool\JsonFeed\Item;
use JDecool\JsonFeed\Reader\ReaderInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class FeedReader implements ReaderInterface
{
    /** @var \Symfony\Component\PropertyAccess\PropertyAccessor */
    private $accessor;

    /** @var FeedReader */
    private static $instance;

    /**
     * Create reader instance
     *
     * @return FeedReader
     */
    public static function create()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function readFromJson($json)
    {
        $content = json_decode($json, true);
        if (!is_array($content)) {
            throw new InvalidArgumentException('Invalid JSONFeed string');
        }

        return $this->readFeedNode($content);
    }

    /**
     * Browse feed node
     *
     * @param array $content
     * @return Feed
     */
    private function readFeedNode(array $content)
    {
        $feed = new Feed('');

        foreach ($content as $key => $value) {
            if ('version' === $key) {
                continue;
            }

            switch ($key) {
                case 'author':
                    $feed->setAuthor($this->readAuthorNode($value));
                    break;

                case 'hubs':
                    $feed->setHubs(array_map([$this, 'readHubNode'], $value));
                    break;

                case 'items':
                    $feed->setItems(array_map([$this, 'readItemNode'], $value));
                    break;

                default:
                    $this->accessor->setValue($feed, $key, $value);
            }
        }

        return $feed;
    }

    /**
     * Browse item node
     *
     * @param array $content
     * @return Item
     */
    private function readItemNode(array $content)
    {
        $id = isset($content['id']) ? $content['id'] : '';

        $item = new Item($id);
        foreach ($content as $key => $value) {
            if ('id' === $key) {
                continue;
            }

            switch ($key) {
                case 'attachments':
                    $item->setAttachments(array_map([$this, 'readAttachmentNode'], $value));
                    break;

                case 'author':
                    $item->setAuthor($this->readAuthorNode($value));
                    break;

                case 'date_published':
                case 'date_modified':
                    $this->accessor->setValue($item, $key, new DateTime($value));
                    break;

                default:
                    $this->accessor->setValue($item, $key, $value);
            }
        }

        return $item;
    }

    /**
     * Browse author node
     *
     * @param array $content
     * @return Author
     */
    private function readAuthorNode(array $content)
    {
        $name = (isset($content['name'])) ? $content['name'] : '';

        $author = new Author($name);
        foreach ($content as $key => $value) {
            if ('name' === $key) {
                continue;
            }

            $this->accessor->setValue($author, $key, $value);
        }

        return $author;
    }

    /**
     * Browse hub node
     *
     * @param array $content
     * @return Hub
     */
    private function readHubNode(array $content)
    {
        $type = isset($content['type']) ? $content['type'] : '';
        $url = isset($content['url']) ? $content['url'] : '';

        return new Hub($type, $url);
    }

    /**
     * Browse attachment node
     *
     * @param array $content
     * @return Attachment
     */
    private function readAttachmentNode(array $content)
    {
        $url = isset($content['url']) ? $content['url'] : '';
        $mimeType = isset($content['mime_type']) ? $content['mime_type'] : '';

        $attachment = new Attachment($url, $mimeType);
        foreach ($content as $key => $value) {
            switch ($key) {
                case 'size_in_bytes':
                    $attachment->setSize($value);
                    break;

                case 'duration_in_seconds':
                    $attachment->setDuration($value);
                    break;
            }
        }

        return $attachment;
    }
}
