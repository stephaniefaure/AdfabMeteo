<?php

namespace AdfabMeteo\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;

class WeatherDataYield extends EventProvider implements ServiceManagerAwareInterface
{

}