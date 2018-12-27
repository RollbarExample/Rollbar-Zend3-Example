<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Level;

class Uncaught extends AbstractActionController
{
    public function indexAction()
    {
        $x = null;
        $x->foo = 5;
    }
}
