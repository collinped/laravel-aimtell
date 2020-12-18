<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class Campaign extends ResourceBase
{
    protected $campaignId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $campaignId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->campaignId = $campaignId;

        $this->siteId = $siteId;
    }

    public function getClicks($campaignId = null)
    {
        $campaignId = ($campaignId ? $campaignId : $this->campaignId);

        return $this->sendRequest(
            'GET',
            $this->resourceName() . '/' .strval($campaignId) . '/clicks'
        );
    }

    public function getResultsByDates(array $dates, $campaignId = null)
    {
        $campaignId = ($campaignId ? $campaignId : $this->campaignId);

        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($campaignId) . '/clicks',
            $dates
        );
    }
}
