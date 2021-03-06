<?php

namespace Api\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;
use Zend\View\Model\JsonModel;


class ApiListener extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events, $priority = 1) 
    {
        // Registr the method which will be triggered on error
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, 
        [$this, 'handleError'], 0);
    }


    /**
     * Return JSON error on API URI(s)
     */
    public function handleError(MvcEvent $e)
    {
        $request = $e->getParam('application')->getRequest();

        if($request instanceof ConsoleRequest){
            return;
        }

        //If you want to convert Response only on some URIs
        //$uri = $request->getUri()->getPath();
        //if(0 !== strpos($uri, '/api')){
        //    return;
        //}

        $response  = $e->getResponse();
        $exception = $e->getResult()->exception;
        $errorType = $e->getError();
        $errorCode = $exception && $exception->getCode() ? $exception->getCode() : 500;
        $errorMsg  = $exception ? $exception->getMessage() : $errorType;
        $json      = new JsonModel(['message' => $errorMsg]);

        $json->setTerminal(true);
        $response->setStatusCode($errorCode);
        $e->setResult($json);
        $e->setViewModel($json);
    }

}   
