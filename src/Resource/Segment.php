<?php


namespace Collinped\Aimtell\Resource;


use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class Segment extends ResourceBase
{
    protected $segmentId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $segmentId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->segmentId = $segmentId;

        $this->siteId = $siteId;
    }

    public function getResultsByDates($segmentId, array $dates)
    {
        $segmentId = ($segmentId ? $segmentId : $this->segmentId);

        return $this->sendRequest(
            'GET',
            $this->resourceName().'/'.strval($segmentId) . '/results',
            $dates
        );
    }
}
