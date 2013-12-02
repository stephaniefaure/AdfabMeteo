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
                'adfabmeteo_weatherlocation_service' => 'AdfabMeteo\Service\WeatherLocation',
                'adfabmeteo_weatherdatayield_service' => 'AdfabMeteo\Service\WeatherDataYield',
                'adfabmeteo_weatherdatause_service' => 'AdfabMeteo\Service\WeatherDataUse',
                'adfabmeteo_weathercode_service' => 'AdfabMeteo\Service\WeatherCode',
            ),

            'factories' => array(
                'adfabmeteo_module_options' => function ($sm) {
                    $config = $sm->get('Configuration');

                    return new Options\ModuleOptions(isset($config['adfabmeteo']) ? $config['adfabmeteo'] : array()
                    );
                },

                'adfabmeteo_weathercode_mapper' => function ($sm) {
                    $mapper = new Mapper\WeatherCode(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                    return $mapper;
                },
                'adfabmeteo_weatherlocation_mapper' => function ($sm) {
                    $mapper = new Mapper\WeatherLocation(
                        $sm->get('doctrine.entitymanager.orm_default')
                    );
                    return $mapper;
                },
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
                'adfabmeteo_associationtable_form' => function ($sm) {
                    $translator = $sm->get('translator');
                    $form = new Form\Admin\AssociationTable(null, $sm, $translator);
//                     $codeObject = new Entity\WeatherCode();
//                     $inputFilter = $codeObject->getInputFilter();

//                     $fileFilter = new \Zend\InputFilter\FileInput('icon');
//                     $validatorChain = new \Zend\Validator\ValidatorChain();
//                     $validatorChain->attach(new \Zend\Validator\File\Exists());
//                     $validatorChain->attach(new \Zend\Validator\File\Extension(array('jpg', 'jpeg', 'png')));
//                     $fileFilter->setValidatorChain($validatorChain);

//                     $inputFilter->add($fileFilter);
//                     $form->setInputFilter($inputFilter);
                    return $form;
                },
            ),
        );
    }
}