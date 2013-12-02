<?php
$adfabmeteo = array(

    /**
     * Drive path to the directory where game media files will be stored
     */
    'media_path' => 'public' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'adfabmeteo',

    /**
     * Url relative path to the directory where weather media files will be stored
     */
    'media_url' => 'media/adfabmeteo',

    /**
     * Url relative path to the directory where weather maps will be saved
     */

    /**
     * Weather Provider API User key
     */
    'userKey' => '',

    /**
     * URL on which we can query for weather forecasts
     */
    'forecastURL' => '',

    /**
     * URL on which we can query for real past weather data
     */
    'pastURL' => '',

    /**
     * URL on which we can query for locations
     */
    'locationURL' => '',
);

/**
 * You do not need to edit below this line
*/
return array(
    'adfabmeteo' => $adfabmeteo,
);