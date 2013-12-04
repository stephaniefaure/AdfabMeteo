<?php
namespace AdfabMeteo\Controller\Frontend;

use Zend\Mvc\Controller\AbstractRestfulController;

use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;
use AdfabMeteo\Service\WeatherDataYield as WeatherDataYieldService;
use AdfabMeteo\Service\WeatherDataUse as WeatherDataUseService;
use DateTime;

use Zend\View\Model\JsonModel;

class WeatherOccurrenceController extends AbstractRestfulController
{
    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    /**
     * @var WeatherDataYieldService
     */
    protected $weatherDataYieldService;

    /**
     * @var WeatherDataUseService
     */
    protected $weatherDataUseService;

    public function getList()
    {
        $locationId = $this->getEvent()->getRouteMatch()->getParam('locationId');
        $dateStr = $this->getEvent()->getRouteMatch()->getParam('date');
        if (!$dateStr || !$locationId) {
            $data = '[ERROR] missing arguments';
        }

        $location = $this->getWeatherLocationService()->getWeatherLocationMapper()->findById($locationId);
        $date = new DateTime($dateStr);
        $data = $this->getWeatherDataYieldService()->getLocationForecasts($location, $date);
        return new JsonModel(array('data' => $data));
    }

    public function getWeatherLocationService()
    {
        if ($this->weatherLocationService === null) {
            $this->weatherLocationService = $this->getServiceLocator()->get('adfabmeteo_weatherlocation_service');
        }
        return $this->weatherLocationService;
    }

    public function setWeatherLocationService($weatherLocationService)
    {
        $this->weatherLocationService = $weatherLocationService;

        return $this;
    }

    public function getWeatherDataUseService()
    {
        if ($this->weatherDataUseService === null) {
            $this->weatherDataUseService = $this->getServiceLocator()->get('adfabmeteo_weatherdatause_service');
        }
        return $this->weatherDataUseService;
    }

    public function setWeatherDataUseService($weatherDataUseService)
    {
        $this->weatherDataUseService = $weatherDataUseService;

        return $this;
    }

    public function getWeatherDataYieldService()
    {
        if ($this->weatherDataYieldService === null) {
            $this->weatherDataYieldService = $this->getServiceLocator()->get('adfabmeteo_weatherdatayield_service');
        }
        return $this->weatherDataYieldService;
    }

    public function setWeatherDataYieldService($weatherDataYieldService)
    {
        $this->weatherDataYieldService = $weatherDataYieldService;

        return $this;
    }

}