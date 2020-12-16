<?php

namespace Collinped\Aimtell;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collinped\Aimtell\Aimtell
 */
class AimtellFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'aimtell';
    }
}
