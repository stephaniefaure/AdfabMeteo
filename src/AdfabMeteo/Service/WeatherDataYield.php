<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;
use AdfabMeteo\Options\ModuleOptions;

use AdfabMeteo\Entity\WeatherLocation;
use AdfabMeteo\Entity\WeatherHourlyOccurrence;
use AdfabMeteo\Entity\WeatherDailyOccurrence;

use AdfabMeteo\Service\WeatherOccurrenceService as WeatherOccurrenceService;
use AdfabMeteo\Service\WeatherCode as WeatherCodeService;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;
use \Datetime;

class WeatherDataYield extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var WeatherCodeService
     */
    protected $weatherCodeService;

    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    /**
     * @var WeatherOccurrenceService
     */
    protected $weatherOccurrenceService;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     *
     * @param array $locationData
     * @param DateTime $date beginning date
     * @param number $numDays number of days to query from beginning date
     * @param number $tp 3 ,6 ,12 or 24
     * @param string $includeLocation
     * @param boolean $fx forecasts
     * @param boolean $cc current condition
     * @param boolean $showComments
     * @return string url
     */
    public function request(array $locationData, DateTime $date=null, $numDays=1, $tp=3, $includeLocation=true, $fx=true, $cc=true, $showComments=false )
    {
        $location = $this->getWeatherLocationService()->createQueryString($locationData);
        if (!$location) {
            return '';
        }
        if (!in_array($tp, array(3, 6, 12, 24))) {
            $tp = 3;
        }
        if(!(int)$numDays || (int)$numDays < 1 || (int)$numDays > 16) {
            $numDays = 1;
        }
        // Set Optional Parameters Value (default)
        $includeLocation = ($includeLocation) ? 'yes' : 'no';
        $fx = ($fx) ? 'yes' : 'no';
        $cc = ($cc) ? 'yes' : 'no';
        $showComments = ($showComments) ? 'yes' : 'no';

        $dateStr = '';
        if ($date) {
            $today = new DateTime("now");
            $diff = $today->diff($date);
            if ($diff->days < 0) {
                $WWOstart = new DateTime("2008-07-01");
                if ($date < $WWOstart) {
                    return '';
                }
                $endDate = '';
                if ($numDays > 1) {
                    $end = new Datetime();
                    $end->setTimestamp($date->getTimestamp()+($numDays*86400));
                    // Beginning and ending dates must have the same month and same year
                    if ($date->format('Y-m') == $end->format('Y-m')) {
                        $endDate = $end->format('Y-m-d');
                    }
                }
                return $this->requestPast($location, $date->format('Y-m-d'), $endDate, $includeLocation);
            } else {
                if ($diff->days == 0) {
                    $dateStr = 'today';
                } elseif ($diff->days == 1) {
                    $dateStr = 'tomorrow';
                } else {
                    $dateStr = $date->format('Y-m-d');
                }
            }
        }
        return $this->requestForecast($location, $numDays, $dateStr, $fx, $cc, $includeLocation, $showComments);
    }

    public function requestPast($location, $date, $endDate, $includeLocation) {
        return $this->getOptions()->getPastURL()
        . '?q=' . $location
        . '&date=' . $date
        . '&enddate=' . $endDate
        . '&includeLocation' . $includeLocation
        . '&format=xml'
        . '&key=' . $this->getOptions()->getUserKey();
    }

    public function requestForecast($location, $date, $numDays, $fx, $cc, $includeLocation, $showComments) {
        return $this->getOptions()->getForecastURL()
        . '?q=' . $location
        . '&num_of_days=' . $numDays
        . '&date=' . $date
        . '&fx=' . $fx
        . '&cc=' . $cc
        . '&includeLocation' . $includeLocation
        . '&showComments=' . $showComments
        . '&format=xml'
        . '&key=' . $this->getOptions()->getUserKey();
    }

    /**
     *
     * @param WeatherLocation $location
     * @param DateTime $date
     */
    public function getLocationForecasts(WeatherLocation $location, DateTime $date)
    {
        return $this->parseForecastsToObjects($location, $this->request($location->getQueryArray(), $date));
    }

    public function parseForecastsToObjects(WeatherLocation $location, $xmlFileURL)
    {
        $xmlContent = simplexml_load_file($xmlFileURL, null, LIBXML_NOCDATA);
        $locations = array();
        foreach ($xmlContent->weather as $daily) {
            $dailyOcc = $this->getWeatherDailyOccurrenceService()->createDaily(array(
                'date' => new Datetime((string) $daily->date),
                'location' => $location,
                'minTemperature' => (float) $daily->mintempC,
                'maxTemperature' => (float) $daily->maxtempC,
                'forecast' => true,)

            );
            foreach ($daily->hourly as $hourly) {
                $hourlyOcc = $this->getWeatherHourlyOccurrenceService()->createHourly(array(
                    'time' => (string) $hourly->time,
                    'dailyOccurrence' => $dailyOcc,
                    'temperature' => (float) $hourly->tempC,
                    'weatherCode' => (int) $hourly->weatherCode
                ,));
            }
        }
        return $locations;
    }

    public function getWeatherDailyOccurrenceService()
    {
        if ($this->weatherOccurrenceService === null) {
            $this->weatherOccurrenceService = $this->getServiceManager()->get('adfabmeteo_weatheroccurrence_service');
        }
        return $this->weatherOccurrenceService;
    }

    public function setWeatherOccurrenceService(WeatherOccurrenceService $weatherOccurrenceService)
    {
        $this->weatherOccurrenceService = $weatherOccurrenceService;
        return $this;
    }

    public function getWeatherCodeService()
    {
        if ($this->weatherCodeService === null) {
            $this->weatherCodeService = $this->getServiceManager()->get('adfabmeteo_weatherlocation_service');
        }
        return $this->weatherCodeService;
    }

    public function setWeatherCodeService(WeatherCodeService $weatherCodeService)
    {
        $this->weatherCodeService = $weatherCodeService;
        return $this;
    }

    public function getWeatherLocationService()
    {
        if ($this->weatherLocationService === null) {
            $this->weatherLocationService = $this->getServiceManager()->get('adfabmeteo_weatherlocation_service');
        }
        return $this->weatherLocationService;
    }

    public function setWeatherLocationService(WeatherLocationService $weatherLocationService)
    {
        $this->weatherLocationService = $weatherLocationService;
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