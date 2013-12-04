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
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => 'adfabmeteo'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'adfabmeteo_controller'             => 'AdfabMeteo\Controller\Frontend\AdfabMeteoController',
            'adfabmeteo_admin_controller'       => 'AdfabMeteo\Controller\Admin\AdfabMeteoController',
            'weathercode_admin_controller'      => 'AdfabMeteo\Controller\Admin\WeatherCodeController',
            'weatherlocation_admin_controller'  => 'AdfabMeteo\Controller\Admin\WeatherLocationController',
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
                                'controller' => 'adfabmeteo_controller',
                                'action' => 'index',
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
            'admin' => array(
                'child_routes' => array(
                    'meteo' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/meteo',
                            'defaults' => array(
                                'controller' => 'adfabmeteo_admin_controller',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'weather-codes' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/weather-codes',
                                    'defaults' => array(
                                        'controller' => 'weathercode_admin_controller',
                                        'action' => 'associate',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'controller' => 'weathercode_admin_controller',
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'list' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/list',
                                            'defaults' => array(
                                                'controller' => 'weathercode_admin_controller',
                                                'action' => 'associate',
                                            ),
                                        ),
                                    ),
                                    'import' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/import',
                                            'defaults' => array(
                                                'controller' => 'weathercode_admin_controller',
                                                'action' => 'import',
                                            ),
                                        ),
                                    ),
                                    'remove' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/remove/:codeId',
                                            'defaults' => array(
                                                'controller' => 'weathercode_admin_controller',
                                                'action' => 'remove',
                                                'codeId' => 0,
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:codeId',
                                            'defaults' => array(
                                                'controller' => 'weathercode_admin_controller',
                                                'action' => 'edit',
                                                'codeId' => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),

                            'weather-locations' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/weather-locations',
                                    'defaults' => array(
                                        'controller' => 'weatherlocation_admin_controller',
                                        'action' => 'list',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/add',
                                            'defaults' => array(
                                                'controller' => 'weatherlocation_admin_controller',
                                                'action' => 'add',
                                            ),
                                        ),
                                    ),
                                    'list' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/list',
                                            'defaults' => array(
                                                'controller' => 'weatherlocation_admin_controller',
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'create' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/create/:city/:country[/:region]/:latitude/:longitude',
                                            'defaults' => array(
                                                'controller' => 'weatherlocation_admin_controller',
                                                'action' => 'create',
                                            ),
                                        ),
                                    ),
                                    'remove' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/remove/:locationId',
                                            'defaults' => array(
                                                'controller' => 'weatherlocation_admin_controller',
                                                'action' => 'remove',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);