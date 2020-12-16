<?php


namespace Collinped\Aimtell\Resource;


use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class Site extends ResourceBase
{
    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->setSiteId($siteId);
    }

    public function create(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName() . 's',
            array(),
            $data,
            $headers
        );
    }

    public function getCode()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/code/'.strval($this->siteId)
        );
    }

    public function getSettings()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->siteId) . '/settings'
        );
    }

    public function updateSettings(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->siteId) . '/settings',
            array(),
            $data,
            $headers
        );
    }

    public function updatePackage(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/package/'.strval($this->siteId),
            array(),
            $data,
            $headers
        );
    }

    public function getKeys()
    {
        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($this->siteId) . '/keys'
        );
    }

    public function upsertKeys(array $data, array $headers = null)
    {
        return $this->sendRequest(
            'POST',
            $this->resourceName().'/'.strval($this->siteId) . '/keys/upsert',
            array(),
            $data,
            $headers
        );
    }

    public function analytics(array $query)
    {
        return $this->sendRequest(
            'GET',
            'report/dashboard/'.strval($this->siteId),
            $query
        );
    }

    public function campaign($campaignId = null): Campaign
    {
        return new Campaign($this->aimtell, $campaignId, $this->siteId);
    }

    public function eventCampaign($eventCampaignId = null): EventCampaign
    {
        return new EventCampaign($this->aimtell, $eventCampaignId, $this->siteId);
    }

    public function apiCampaign($apiCampaignId = null): ApiCampaign
    {
        return new ApiCampaign($this->aimtell, $apiCampaignId, $this->siteId);
    }

    public function segment($segmentId = null): Segment
    {
        return new Segment($this->aimtell, $segmentId, $this->siteId);
    }

    public function rssNotification($rssNotificationId = null): RssNotification
    {
        return new RssNotification($this->aimtell, $rssNotificationId, $this->siteId);
    }

    public function subscriber($subscriberId = null): Subscriber
    {
        return new Subscriber($this->aimtell, $subscriberId, $this->siteId);
    }

    public function push(): Push
    {
        return new Push($this->aimtell, $this->siteId);
    }
}
