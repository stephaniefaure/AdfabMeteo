<?php

namespace AdfabMeteo\Form\Admin;

use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\Form\Element;
use PlaygroundCore\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class WeatherCode extends Fieldset
{
    protected $serviceManager;

    public function __construct($name = null, ServiceManager $serviceManager, Translator $translator)
    {
        parent::__construct($name);

        $this->setServiceManager($serviceManager);

        $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        $this->setHydrator(new DoctrineHydrator($entityManager, 'AdfabMeteo\Entity\WeatherCode'))
        ->setObject(new \AdfabMeteo\Entity\WeatherCode());

        $this->setAttribute('method','post');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'type'  => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'code',
            'options' => array(
                'label' => $translator->translate('Code', 'adfabmeteo'),
            ),
            'attributes' => array(
                'type' => 'text',
                'placeholder' => $translator->translate('Code', 'adfabmeteo'),
            ),
        ));

        $this->add(array(
            'name' => 'description',
            'options' => array(
                'label' => $translator->translate('description', 'adfabmeteo')
            ),
            'attributes' => array(
                'type' => 'text'
            )
        ));

        $this->add(array(
            'name' => 'icon',
            'options' => array(
                'label' => $translator->translate('icône', 'adfabmeteo')
            ),
            'attributes' => array(
                'type' => 'file'
            )
        ));
        $this->add(array(
            'name' => 'iconURL',
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name' => 'default',
            'options' => array(
                'label' => $translator->translate('default', 'adfabmeteo')
            ),
            'attributes' => array(
                'type' => 'hidden'
            )
        ));

        $codes = $this->getNonDefaultCodes();
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'associatedCode',
            'options' => array(
                'empty_option' => $translator->translate('Pas d\'association, valeur par défaut', 'adfabmeteo'),
                'value_options' => $codes,
                'label' => $translator->translate('Code associé', 'adfabmeteo')
            )
        ));

    }

    public function getNonDefaultCodes()
    {
    	$codes = array();
    	$codeService = $this->getServiceManager()->get('adfabmeteo_weathercode_service');
    	$results = $codeService->getWeatherCodeMapper()->findBy(array('default'=>0));

    	foreach ($results as $result) {
    		$codes[$result->getId()] = $result->getDescription();
    	}

    	return $codes;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager ()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param  ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager (ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }
}
