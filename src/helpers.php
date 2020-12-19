<?php

use Collinped\Aimtell\Aimtell;

if (! function_exists('aimtell')) {
    /**
     * @return Aimtell
     */
    function aimtell(): Aimtell
    {
        return new Aimtell(config('aimtell.api_key'), config('aimtell.default_site_id'), config('aimtell.white_label_id'));
    }
}
