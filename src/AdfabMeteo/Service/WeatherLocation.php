<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;

use AdfabMeteo\Mapper\WeatherLocation  as WeatherLocationMapper;

class WeatherLocation extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var WeatherLocationMapper
     */
    protected $weatherLocationMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    protected $locationURL;

    public function createLocation($data = array())
    {
        if ($data['city'] && $data['country']) {

        }
    }

    public function getLocationURL()
    {

    }

    public function getWeatherLocationMapper()
    {
        if ($this->weatherLocationMapper === null) {
            $this->weatherLocationMapper = $this->getServiceManager()->get('adfabmeteo_weatherlocation_mapper');
        }
        return $this->weatherLocationMapper;
    }

    public function setWeatherLocationMapper(WeatherLocationMapper $weatherLocationMapper)
    {
        $this->weatherLocationMapper = $weatherLoactionMapper;
        return $this;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceManager()->get('adfabmeteo_module_options'));
        }
        return $this->options;
    }
}
