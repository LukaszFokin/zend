<?php
return array(
	'router' => array(
		'routes' => array(
			'application' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/app',
					'defaults' => array(
						'__NAMESPACE__' => 'Estoque\Controller',
						'controller' => 'Index',
						'action' => 'index'
					)
				)
			)
		)
	),

	'controllers' => array(
		'invokables' => array(
			'Estoque\Controller\Index' => 'Estoque\Controller\IndexController'
		)
	),
	
	'view_manager' => array(
		'template_path_stack' => array (
			__DIR__.'/../view/',
		)
	),

	'doctrine' => array(
          'driver' => array(
            'application_entities' => array(
              'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
              'cache' => 'array',
              'paths' => array(__DIR__ . '/../src/Estoque/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Estoque\Entity' => 'application_entities'
                ),
            ),
        ),
    ),
);