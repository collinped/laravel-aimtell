<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class EventCampaign extends ResourceBase
{
    protected $campaignId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $campaignId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->campaignId = $campaignId;

        $this->siteId = $siteId;
    }

    public function getResultsByDates($campaignId, array $dates)
    {
        $campaignId = ($campaignId ? $campaignId : $this->campaignId);

        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($campaignId) . '/results',
            $dates
        );
    }
}
