<?php
namespace AdfabMeteo\Form\Admin;

use Zend\Form\Form;
use Zend\Form\Element;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class WeatherLocation extends ProvidesEventsForm
{
    protected $serviceManager;

    public function __construct ($name = null, ServiceManager $sm, Translator $translator)
    {
        parent::__construct($name);

        $this->setServiceManager($sm);

        $this->setAttribute('method', 'post');

        $this->add(array(
            'type'    => 'Zend\Form\Element\Hidden',
            'name'    => 'id',
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Input',
            'name'    => 'city',
            'options' => array(
                'label' => $translator->translate('Ville', 'adfabmeteo'),
            )
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Input',
            'name'    => 'country',
            'options' => array(
                'label' => $translator->translate('Pays', 'adfabmeteo'),
            )
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Input',
            'name'    => 'latitude',
            'options' => array(
                'label' => $translator->translate('Latitude', 'adfabmeteo'),
            )
        ));

        $this->add(array(
            'type'    => 'Zend\Form\Element\Input',
            'name'    => 'longitude',
            'options' => array(
                'label' => $translator->translate('Longitude', 'adfabmeteo'),
            )
        ));

        $submitElement = new Element\Button('submit');
        $submitElement->setAttributes(array(
            'type'  => 'submit',
            'class' => 'btn btn-primary',
        ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));
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