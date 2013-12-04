<?php
namespace AdfabMeteo\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdfabMeteoController extends AbstractActionController
{
    public function indexAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }

}