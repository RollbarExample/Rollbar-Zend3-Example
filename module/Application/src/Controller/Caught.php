<?php


namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Level;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
use Zend\Log\Formatter\Simple;

class Caught extends AbstractActionController
{
    public function indexAction()
    {
        try{
            $value = 5/0;
        } catch (Zend_Exception $e) {
			echo $e->getMessage();
        }
    }
}
