<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'adfabmeteo_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => __DIR__ . '/../src/AdfabMeteo/Entity'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'AdfabMeteo\Entity' => 'adfabmeteo_entity'
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../views/admin',
            __DIR__ . '/../views/frontend'
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'adfabmeteocontroller' => 'AdfabMeteo\Controller\AdfabMeteoController',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'forecastWidget' => 'AdfabMeteo\View\Helper\ForecastWidget',
        ),
    ),
    'router' => array(
        'routes' =>array(
            'frontend' => array(
                'child_routes' => array(
                    'meteo' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'meteo',
                            'defaults' => array(
                                'controller' => 'adfabmeteocontroller',
                                'action' => 'index'
                            )
                        ),
//                         'may_terminate' => true,
//                         'child_routes' => array(
//                             'result' => array(
//                                 'type' => 'Literal',
//                                 'options' => array(
//                                     'route' => '/resultat',
//                                     'defaults' => array(
//                                         'controller' => 'smartboxcontroller',
//                                         'action' => 'result',
//                                     ),
//                                 ),
//                             ),
//                         ),
                    ),
                ),
            ),
        ),
    ),
);