<?php

namespace AdfabMeteo\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * drive path to weather media files
     */
    protected $media_path = 'public/media/adfabweather';

    /**
     * url path to story media files
     */
    protected $media_url = 'media/adfabweather';

    /**
     * API user key
     */
    protected $userKey = '';

    /**
     * URL on which we will query for weather forecasts
     */
    protected $forecastURL = '';

    /**
     * URL on which we will query for past days real weather data
     */

    protected $pastURL = '';

    /**
     * URL on which we will query for locations
     */
    protected $locationURL = '';

    /**
     * Set media path
     *
     * @param  string $media_path
     * @return \AdfabMeteo\Options\ModuleOptions
     */
    public function setMediaPath($media_path)
    {
        $this->media_path = $media_path;

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaPath()
    {
        return $this->media_path;
    }

    /**
     *
     * @param  string $media_url
     * @return \AdfabMeteo\Options\ModuleOptions
     */
    public function setMediaUrl($media_url)
    {
        $this->media_url = $media_url;

        return $this;
    }

    /**
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->media_url;
    }

    /**
     * @return $userKey
     */
    public function getUserKey()
    {
        return $this->$userKey;
    }

    /**
     * @param boolean $userKey
     */
    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;
        return $this;
    }

}