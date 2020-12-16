<?php

namespace Collinped\Aimtell;

use Collinped\Aimtell\Resource\ApiCampaign;
use Collinped\Aimtell\Resource\EventCampaign;
use Collinped\Aimtell\Resource\Push;
use Collinped\Aimtell\Resource\RssNotification;
use Collinped\Aimtell\Resource\Segment;
use InvalidArgumentException;
use Collinped\Aimtell\Resource\Site;
use Collinped\Aimtell\Resource\Campaign;
use Collinped\Aimtell\Resource\Subscriber;

class Aimtell
{
    protected ?string $apiKey = null;

    protected ?string $whiteLabelId = null;

    protected ?string $defaultSiteId = null;

    public function __construct($apiKey = null, $whiteLabelId = null, $defaultSiteId = null)
    {
        if (!is_null($apiKey)) {
            $this->setApiKey($apiKey);
        }

        if (!is_null($whiteLabelId)) {
            $this->setWhitelabelId($whiteLabelId);
        }

        if (!is_null($defaultSiteId)) {
            $this->setDefaultSiteId($defaultSiteId);
        }
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey($apiKey): Aimtell
    {
        if (!is_string($apiKey) || empty($apiKey)) {
            throw new InvalidArgumentException('API Key must be a non-empty string.');
        }
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getWhiteLabelId(): ?string
    {
        return $this->whiteLabelId;
    }

    public function setWhitelabelId($whiteLabelId): Aimtell
    {
        if (!is_string($whiteLabelId) || empty($whiteLabelId)) {
            throw new InvalidArgumentException('White Label ID must be a non-empty string.');
        }

        $this->whiteLabelId = $whiteLabelId;

        return $this;
    }

    public function getDefaultSiteId(): ?string
    {
        return $this->defaultSiteId;
    }

    public function setDefaultSiteId($siteId): Aimtell
    {
        if (!is_string($siteId) || empty($siteId)) {
            throw new InvalidArgumentException('Default Site ID must be a non-empty string.');
        }

        $this->defaultSiteId = $siteId;

        return $this;
    }

    public function site($siteId = null): Site
    {
        $siteId = (!is_null($siteId) ? $siteId : $this->defaultSiteId);

        return new Site($this, $siteId);
    }

    public function push(): Push
    {
        return new Push($this, $this->defaultSiteId);
    }

    public function subscriber($subscriberId = null): Subscriber
    {
        return new Subscriber($this, $subscriberId, $this->defaultSiteId);
    }

    public function campaign($campaignId = null): Campaign
    {
        return new Campaign($this, $campaignId, $this->defaultSiteId);
    }

    public function eventCampaign($eventCampaignId = null): EventCampaign
    {
        return new EventCampaign($this, $eventCampaignId, $this->defaultSiteId);
    }

    public function apiCampaign($apiCampaignId = null): ApiCampaign
    {
        return new ApiCampaign($this, $apiCampaignId, $this->defaultSiteId);
    }

    public function segment($segmentId = null): Segment
    {
        return new Segment($this, $segmentId, $this->defaultSiteId);
    }

    public function rssNotification($rssNotificationId = null): RssNotification
    {
        return new RssNotification($this, $rssNotificationId, $this->defaultSiteId);
    }

}
