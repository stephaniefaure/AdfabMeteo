<?php

namespace AdfabMeteo;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $options = $sm->get('playgroundcore_module_options');
        $locale = $options->getLocale();
        $translator = $sm->get('translator');
        if (!empty($locale)) {
            //translator
            $translator->setLocale($locale);

            // plugins
            $translate = $sm->get('viewhelpermanager')->get('translate');
            $translate->getTranslator()->setLocale($locale);
        }
        AbstractValidator::setDefaultTranslator($translator,'playgroundcore');

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Here we need to schedule the core cron service

        // If cron is called, the $e->getRequest()->getPost() produces an error so I protect it with
        // this test
        if ((get_class($e->getRequest()) == 'Zend\Console\Request')) {
            return;
        }
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoLoader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'adfabForecastWidget' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\ForecastWidget();

                    return $viewHelper;
                },
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
            ),

            'invokables' => array(
            ),

            'factories' => array(
                'adfabmeteo_weatherdailyoccurrence_mapper' => function ($sm) {
                    $mapper = new Mapper\WeatherDailyOccurrence(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                    return $mapper;
                },
                'adfabmeteo_weatherhourlyoccurrence_mapper' => function ($sm) {
                    $mapper = new Mapper\WeatherHourlyOccurrence(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                    return $mapper;
                },
            ),
        );
    }
}