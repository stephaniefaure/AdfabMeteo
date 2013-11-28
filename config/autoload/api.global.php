<?php
return array(
    'WWO_API' => array (
        'accounts' => array (
            'free' => array(
                'urls' => array (
                    'forecast' => 'http://api.worldweatheronline.com/free/v1/weather.ashx',
                    'past' => null,
                    'location' => 'http://api.worldweatheronline.com/free/v1/search.ashx',
                ),
                'key' => '',
            ),

            'premium' => array(
                'urls' => array (
                    'forecast' => 'http://api.worldweatheronline.com/premium/v1/weather.ashx',
                    'past' => 'http://api.worldweatheronline.com/premium/v1/past-weather.ashx',
                    'location' => 'http://api.worldweatheronline.com/premium/v1/search.ashx',
                ),
                'key' => '',
            ),
        ),
    ),
);

