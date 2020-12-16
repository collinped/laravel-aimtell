<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class Subscriber extends ResourceBase
{
    protected $subscriberId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $subscriberId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->subscriberId = $subscriberId;

        $this->siteId = $siteId;
    }

    public function all(array $query = [])
    {
        $siteId = (isset($query['site_id']) ? $query['site_id'] : $this->siteId);

        //TODO - Require the SiteId - Exception Error if not provided
        return $this->sendRequest(
            'GET',
            $this->resourceName() . 's/' . strval($siteId),
            $query
        );
    }

    public function get(array $query = [])
    {
        $siteId = ($query['site_id'] ? $query['site_id'] : $this->siteId);

        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($siteId),
            $query
        );
    }

    public function setAttributes(array $attributes, array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->subscriberId;

        $data['attributes'] = $attributes;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    public function trackEvent(array $event, array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->subscriberId;

        $data['event'] = $event;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }

    public function optOut(array $data)
    {
        $siteId = ($data['site_id'] ? $data['site_id'] : $this->siteId);

        $data['idSite'] = strval($siteId);
        $data['subscriber_uid'] = $this->subscriberId;
        $data['optout'] = true;

        return $this->sendRequest(
            'POST',
            $this->resourceName(),
            [],
            $data
        );
    }
}
