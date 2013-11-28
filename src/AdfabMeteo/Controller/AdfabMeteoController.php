<?php
namespace AdfabMeteo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;

class AdfabMeteoController extends AbstractActionController
{
    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    public function indexAction()
    {
        $viewModel = new ViewModel();

        $api_config = $this->getServiceLocator()->get('Config');
        $api_config = $api_config->modules;
        var_dump($api_config);
//         $api_config->accounts =  $api_config->accounts;
//         $api_config->accounts->free =  $api_config->accounts->free;
//         $api_config->accounts->free->key = 'aaaaaaaaaaaaaaaaaaaa';

        $writer = new Zend\Config\Writer\PhpArray();
        $writer->toFile($apiconfig);

//         var_dump(json_encode(\AdfabMeteo\Module::getApiConfig()));
        return $viewModel;
    }

    public function getWeatherLocationService()
    {
        if ($this->weatherLocationService event === null) {
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