<?php
namespace AdfabMeteo\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;
use AdfabMeteo\Service\WeatherCode as WeatherCodeService;

class AdfabMeteoController extends AbstractActionController
{
    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    /**
     * @var WeatherCodeService
     */
    protected $weatherCodeService;


    public function indexAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function setupWeatherCodesAction()
    {

        $form = $this->getServiceLocator()->get('adfabmeteo_associationtable_form');
        $viewModel = new ViewModel();
        $viewModel->setVariables(
            array(
                'form' =>$form,
            )
        );
        return $viewModel;
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

    public function getWeatherCodeService()
    {
        if ($this->weatherCodeService === null) {
            $this->weatherCodeService = $this->getServiceLocator()->get('adfabmeteo_weathercode_service');
        }
        return $this->weatherCodeService;
    }

    public function setWeatherCodeService($weatherCodeService)
    {
        $this->weatherCodeService = $weatherCodeService;

        return $this;
    }

}