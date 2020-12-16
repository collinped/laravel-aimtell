<?php


namespace Collinped\Aimtell\Resource;


use Collinped\Aimtell\Aimtell;
use Collinped\Aimtell\ResourceBase;

class RssNotification extends ResourceBase
{
    protected $rssNotificationId;

    public ?string $siteId;

    public function __construct(Aimtell $aimtell, $rssNotificationId = null, $siteId = null)
    {
        parent::__construct($aimtell);

        $this->rssNotificationId = $rssNotificationId;

        $this->siteId = $siteId;
    }
}
