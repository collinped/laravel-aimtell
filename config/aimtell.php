<?php

return [
    /**
     * API Key provided by Aimtell
     * https://dashboard.aimtell.com/api-key
     */
    'api_key' => env('AIMTELL_API_KEY'),

    /**
     * Site ID for the default website
     * https://dashboard.aimtell.com/website
     */
    'default_site_id' => env('AIMTELL_DEFAULT_SITE_ID'),

    /**
     * Must contact Aimtell to obtain a white label id
     */
    'white_label_id' => env('AIMTELL_WHITE_LABEL_ID'),
];
