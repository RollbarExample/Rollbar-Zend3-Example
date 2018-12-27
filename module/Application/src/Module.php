<?php

namespace Application;
use Rollbar\Rollbar;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Rollbar\Payload\Level;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $config = $application->getConfig();

        Rollbar::init($config['rollbar']);

        $eventManager = $application->getEventManager();
	//	$exception = $event->getParam('exception');
        //Rollbar::logger()->log(Level::ERROR, $exception, array(), true);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onErrorDemo']);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, [$this, 'onErrorDemo']);
    }
    public function onErrorDemo(MvcEvent $event)
    {
        $exception = $event->getParam('exception');
        Rollbar::logger()->log(Level::ERROR, $exception, array(), true);
    }
}
