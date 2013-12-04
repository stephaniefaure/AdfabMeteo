<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;
use PlaygroundCore\Filter\Slugify;
use Zend\Stdlib\ErrorHandler;
use AdfabMeteo\Options\ModuleOptions;

use AdfabMeteo\Entity\WeatherDailyOccurrence;
use AdfabMeteo\Entity\WeatherHourlyOccurrence;
use AdfabMeteo\Entity\Location;

use AdfabMeteo\Mapper\WeatherDailyOccurrence as WeatherDailyOccurrenceMapper;
use AdfabMeteo\Mapper\WeatherHourlyOccurrence as WeatherHourlyOccurrenceMapper;

class WeatherOccurrence extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var WeatherCodeMapper
     */
    protected $weatherCodeMapper;

    /**
     * @var WeatherDailyOccurrenceMapper
     */
    protected $weatherDailyOccurrenceMapper;

    /**
     * @var WeatherHourlyOccurrenceMapper
     */
    protected $weatherHourlyOccurrenceMapper;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function createDaily(array $data)
    {
        $weatherDaily = new WeatherDailyOccurrence();
        $weatherDaily->populate($data);
        if ($data['location'] instanceof \AdfabMeteo\Entity\WeatherLocation) {
            $weatherDaily->setLocation($data['location']);
        }
        if ($data['date'] instanceof \DateTime) {
            $weatherDaily->setDate($data['date']);
        }
        $weatherDaily = $this->getWeatherDailyOccurrenceMapper()->insert($weatherDaily);
        if (!$weatherDaily) {
            return false;
        }
        return $weatherDaily;
    }

    public function createHourly(array $data)
    {
        $weatherHourly = new WeatherHourlyOccurrence();
        $weatherHourly->populate($data);
        if ($data['dailyOccurrence'] instanceof WeatherDailyOccurrence) {
            $weatherHourly->setDailyOccurrence($data['dailyOccurrence']);
        }
        if ($data['time']) {
            $date = $weatherHourly->getDailyOccurrence()->getDate();
            $time = $date->setTime((int)substr($data['time'], -4, -2), (int)substr($data['time'], 2, 4));
        }
        $weatherCode = $this->getWeatherCodeMapper()->findDefaultByCode((int) $data['weatherCode']);
        if ($weatherCode) {
            $weatherHourly->setWeatherCode($weatherCode);
        }

        $weatherHourly = $this->getWeatherDailyOccurrenceMapper()->insert($weatherHourly);
        if (!$weatherHourly) {
            return false;
        }
        return $weatherDaily;
    }

    public function getWeatherCodeMapper()
    {
        if (null === $this->weatherCodeMapper) {
            $this->weatherCodeMapper = $this->getServiceManager()->get('adfabmeteo_weathercode_mapper');
        }
        return $this->weatherCodeMapper;
    }

    public function setWeatherCodeMapper(WeatherCodeMapper $weatherCodeMapper)
    {
        $this->weatherCodeMapper = $weatherCodeMapper;
        return $this;
    }

    public function getWeatherDailyOccurrenceMapper()
    {
        if ($this->weatherDailyOccurrenceMapper === null) {
            $this->weatherDailyOccurrenceMapper = $this->getServiceManager()->get('adfabmeteo_weatherdailyoccurrence_mapper');
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
            $this->weatherHourlyOccurrenceMapper = $this->getServiceManager()->get('adfabmeteo_weatherhourlyoccurrence_mapper');
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