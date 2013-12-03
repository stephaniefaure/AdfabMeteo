<?php

namespace AdfabMeteo\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;

use Zend\Paginator\Paginator;
use PlaygroundCore\ORM\Pagination\LargeTablePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;

class WeatherLocationController extends AbstractActionController
{
    /**
     * @var WeatherLocationService
     */
    protected $weatherLocationService;

    public function addAction()
    {
        return new ViewModel(array(

        ));
    }

    public function editAction()
    {
        return new ViewModel(array(

        ));
    }

    public function removeAction()
    {

    }

    public function listAction()
    {
        $adapter = new DoctrineAdapter(
                        new LargeTablePaginator(
                            $this->getWeatherLocationService()->getWeatherLocationMapper()->queryAll(array('country' => 'ASC'))
                        )
                    );
        $paginator = new Paginator($adapter);

        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('p'));

        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'locations' => $paginator,
            'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
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

}