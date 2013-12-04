<?php

namespace AdfabMeteo\View\Helper;

use Zend\View\Helper\AbstractHelper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use AdfabMeteo\Entity\WeatherLocation;
use AdfabMeteo\Entity\WeatherDailyOccurrence;
use AdfabMeteo\Entity\WeatherHourlyOccurrence;

class WeatherTableWidget extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function __invoke()
    {

    }

    public function getView()
    {
        // TODO: Auto-generated method stub
    }


    public function setView($view) {

    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
