<?php

declare(strict_types=1);

namespace JDecool\JsonFeed\Writer\Version1;

use DateTime;
use JDecool\JsonFeed\Attachment;
use JDecool\JsonFeed\Author;
use JDecool\JsonFeed\Feed;
use JDecool\JsonFeed\Hub;
use JDecool\JsonFeed\Item;
use JDecool\JsonFeed\Versions;
use JDecool\JsonFeed\Writer\RendererInterface;

class Renderer implements RendererInterface
{
    /** @var int `json_encode` bitmask */
    private $flags = 0;

    /**
     * Constructor
     *
     * @property int $flags
     */
    public function __construct($flags = null)
    {
        if (null === $flags) {
            $flags = JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT;
        }

        $this->flags = $flags;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Feed $feed)
    {
        $result = [
            'version' => Versions::VERSION_1,
            'title' => $feed->getTitle(),
        ];

        if ($homepageUrl = $feed->getHomepageUrl()) {
            $result['home_page_url'] = $homepageUrl;
        }

        if ($feedUrl = $feed->getFeedUrl()) {
            $result['feed_url'] = $feedUrl;
        }

        if ($description = $feed->getDescription()) {
            $result['description'] = $description;
        }

        if ($userComment = $feed->getUserComment()) {
            $result['user_comment'] = $userComment;
        }

        if ($nextUrl = $feed->getNextUrl()) {
            $result['next_url'] = $nextUrl;
        }

        if ($icon = $feed->getIcon()) {
            $result['icon'] = $icon;
        }

        if ($favicon = $feed->getFavicon()) {
            $result['favicon'] = $favicon;
        }

        if ($author = $feed->getAuthor()) {
            $result['author'] = $this->renderAuthor($author);
        }

        if (null !== $expired = $feed->isExpired()) {
            $result['expired'] = (bool) $expired;
        }

        if ($items = $feed->getItems()) {
            $result['items'] = array_map(function(Item $item) {
                return $this->renderItem($item);
            }, $items);
        }

        if ($hubs = $feed->getHubs()) {
            $result['hubs'] = array_map(function(Hub $hub) {
                return $this->renderHub($hub);
            }, $hubs);
        }

        return json_encode($result, $this->flags);
    }

    /**
     * Render item
     *
     * @param Item $item
     * @return array
     */
    private function renderItem(Item $item)
    {
        $result = [
            'id' => $item->getId(),
        ];

        if ($url = $item->getUrl()) {
            $result['url'] = $url;
        }

        if ($externalUrl = $item->getExternalUrl()) {
            $result['external_url'] = $externalUrl;
        }

        if ($title = $item->getTitle()) {
            $result['title'] = $title;
        }

        if ($contentHtml = $item->getContentHtml()) {
            $result['content_html'] = $contentHtml;
        }

        if ($contentText = $item->getContentText()) {
            $result['content_text'] = $contentText;
        }

        if ($summary = $item->getSummary()) {
            $result['summary'] = $summary;
        }

        if ($image = $item->getImage()) {
            $result['image'] = $image;
        }

        if ($bannerImage = $item->getBannerImage()) {
            $result['banner_image'] = $bannerImage;
        }

        if ($datePublished = $item->getDatePublished()) {
            $result['date_published'] = $datePublished->format(DateTime::ATOM);
        }

        if ($dateModified = $item->getDateModified()) {
            $result['date_modified'] = $dateModified->format(DateTime::ATOM);
        }

        if ($tags = $item->getTags()) {
            $result['tags'] = $tags;
        }

        if ($attachments = $item->getAttachments()) {
            $result['attachments'] = array_map(function(Attachment $attachment) {
                return $this->renderAttachment($attachment);
            }, $attachments);
        }

        if ($author = $item->getAuthor()) {
            $result['author'] = $this->renderAuthor($author);
        }

        if ($extensions = $item->getExtensions()) {
            foreach ($extensions as $key => $extension) {
                $result['_'.$key] = $extension;
            }
        }

        return $result;
    }

    /**
     * Render attachment
     *
     * @param Attachment $attachment
     * @return array
     */
    private function renderAttachment(Attachment $attachment)
    {
        $result = [
            'url' => $attachment->getUrl(),
            'mime_type' => $attachment->getMimeType(),
        ];

        if ($title = $attachment->getTitle()) {
            $result['title'] = $title;
        }

        if ($size = $attachment->getSize()) {
            $result['size_in_bytes'] = $size;
        }

        if ($duration = $attachment->getDuration()) {
            $result['duration_in_seconds'] = $duration;
        }

        return $result;
    }

    /**
     * Render author
     *
     * @param Author $author
     * @return array
     */
    private function renderAuthor(Author $author)
    {
        $result = [];

        if ($name = $author->getName()) {
            $result['name'] = $name;
        }

        if ($url = $author->getUrl()) {
            $result['url'] = $url;
        }

        if ($avatar = $author->getAvatar()) {
            $result['avatar'] = $avatar;
        }

        return $result;
    }

    /**
     * Render hub
     *
     * @param Hub $hub
     * @return array
     */
    private function renderHub(Hub $hub)
    {
        return [
            'type' => $hub->getType(),
            'url' => $hub->getUrl(),
        ];
    }
}
