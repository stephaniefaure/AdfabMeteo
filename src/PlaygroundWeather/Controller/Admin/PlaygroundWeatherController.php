<?php
namespace PlaygroundWeather\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PlaygroundWeatherController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

}