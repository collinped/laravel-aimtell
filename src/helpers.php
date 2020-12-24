<?php

use Collinped\LaravelAimtell\Aimtell;

if (! function_exists('aimtell')) {
    /**
     * @param string|null $apiKey
     * @return Aimtell
     */
    function aimtell(?string $apiKey = null): Aimtell
    {
        return new Aimtell(
            $apiKey ?: config('aimtell.api_key'),
            config('aimtell.default_site_id'),
            config('aimtell.white_label_id')
        );
    }
}
