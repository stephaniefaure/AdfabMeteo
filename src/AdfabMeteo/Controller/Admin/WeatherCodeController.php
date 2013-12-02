<?php
namespace AdfabMeteo\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use AdfabMeteo\Service\WeatherLocation as WeatherLocationService;
use AdfabMeteo\Service\WeatherCode as WeatherCodeService;
use Zend\Form\Form;
use AdfabMeteo\Entity\WeatherCode;

class WeatherCodeController extends AbstractActionController
{
    /**
     * @var WeatherCodeService
     */
    protected $weatherCodeService;


    public function indexAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('adfabmeteo_associationtable_form');
        $form->get('submit')->setLabel("Créer");
        $form->get('codes')->setCount(1)->prepareFieldset();
        $form->setAttribute('action', '');

        $code = new WeatherCode();
        $form->bind($code);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $data['default'] = 0;
            $form->setData($data);
//             var_dump($form);
            if ($form->isValid()) {
                $this->getWeatherCodeService()->create($form->getData());
            } else {
                var_dump($form->getMessages());
                var_dump($form->get('codes')->getMessages());
            }
        }

        $viewModel = new ViewModel();
        $viewModel->setVariables(
            array(
                'form' => $form,
            )
        );
        return $viewModel;
    }

    public function removeAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function importAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }


    public function associateAction()
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