<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;

use AdfabMeteo\Mapper\WeatherDailyOccurrence as WeatherDailyOccurrenceMapper;
use AdfabMeteo\Mapper\WeatherHourlyOccurrence as WeatherHourlyOccurrenceMapper;

class WeatherDataYield extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var WeatherDailyOccurrenceMapper
     */
    protected $weatherDailyOccurrenceMapper;

    /**
     * @var WeatherHourlyOccurrenceMapper
     */
    protected $weatherHourlyOccurrenceMapper;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function createRequestWWO(City $city, DateTime $date)
    {

    }

    public function getWeatherDailyOccurrenceMapper()
    {
        if ($this->weatherDailyOccurrenceMapper === null) {
            $this->weatherDailyOccurrenceMapper events= $this->getServiceManager()->get('adfabmeteo_weatherdailyoccurrence_mapper');
        }
        return $this->weatherDailyOccurrenceMapper;
    }

    public function setWeatherDailyOccurrenceMapper(WeatherDailyOccurrenceMapper $weatherDailyOccurrenceMapper)
    {
        $this->weatherDailyOccurrenceMapper = $weatherDailyOccurrenceMapper;
        return $this;
    }

    public function getWeatherHourlyOccurrenceMapper()
    {
        if ($this->weatherHourlyOccurrenceMapper === null) {
            $this->weatherHourlyOccurrenceMapper events= $this->getServiceManager()->get('adfabmeteo_weatherhourlyoccurrence_mapper');
        }
        return $this->weatherHourlyOccurrenceMapper;
    }

    public function setWeatherHourlyOccurrenceMapper(WeatherHourlyOccurrenceMapper $weatherHourlyOccurrenceMapper)
    {
        $this->weatherHourlyOccurrenceMapper = $weatherHourlyOccurrenceMapper;
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