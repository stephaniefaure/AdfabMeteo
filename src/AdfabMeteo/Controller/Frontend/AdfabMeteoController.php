<?php
namespace AdfabMeteo\Controller\Frontend;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;
use Datetime;

class AdfabMeteoController extends AbstractActionController
{
    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    public function indexAction()
    {
        $now = new Datetime("now");
        var_dump(substr($str, -4, -2));
        var_dump(substr($str, 2, 4));
        $var = $now->setTime((int)substr($str, -4, -2), (int)substr($str, 2, 4));
        var_dump($var);
        return new ViewModel(array(
//             'val' => $var,
        ));
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

}