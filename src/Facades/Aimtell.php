<?php

namespace Collinped\LaravelAimtell\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collinped\LaravelAimtell\Aimtell
 */
class Aimtell extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'aimtell';
    }
}
