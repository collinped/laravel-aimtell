<?php


namespace Collinped\Aimtell\Resource;

use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class RssCampaign extends ResourceBase
{
    protected $campaignId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $campaignId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->campaignId = $campaignId;

        $this->siteId = $siteId;
    }
}
