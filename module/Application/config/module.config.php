<?php


namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Interop\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Monolog\ErrorHandler;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'caught' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/caught',
                    'defaults' => [
                        'controller' => Controller\Caught::class,
                         'action'     => 'index',
                    ],
                ],
            ],
            'uncaught' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/uncaught',
                    'defaults' => [
                        'controller' => Controller\Uncaught::class,
                         'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\Caught::class => InvokableFactory::class,
            Controller\Uncaught::class => InvokableFactory::class,
        ],
    ],/*
    'listeners'          => [
        Controller\ApiListener::class    // Register the class listener
    ],
    'service_manager'    => [
        'factories' => [
            // Register the class (of course you can use Factory)
            Controller\ApiListener::class => InvokableFactory::class
        ],
    ],*/
    'dependencies' => [
        'factories' => [
            'AppLogger' => function (ContainerInterface $container) {
                $logger = new Logger('zend_rollbar');

                $logger->pushHandler(new StreamHandler(__DIR__ . '/../data/log/zend_rollbar.log', Logger::ERROR));
                $logger->pushHandler(new FirePHPHandler());
                $logger->pushHandler(new ErrorLogHandler());

                return $logger;
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
           // 'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
