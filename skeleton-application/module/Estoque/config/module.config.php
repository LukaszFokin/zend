<?php
return array(
	'router' => array(
		'routes' => array(
			'application' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/[:controller[/:action[/:id]]]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]*'
					),
					'defaults' => array(
						'__NAMESPACE__' => 'Estoque\Controller',
						'controller' => 'Index',
						'action' => 'index'
					)
				)
			),

			'produto' => array(
				'type' => 'Segment',
				'options' => array(
					'route' => '/Produtos[/:page]',
					'constraints' => array(
						'page' => '[0-9]*'
					),
					'defaults' => array(
						'__NAMESPACE__' => 'Estoque\Controller',
						'controller' => 'Index',
						'action' => 'index',
						'page' => 1
					)
				)
			)
		)
	),

	'controllers' => array(
		'invokables' => array(
			'Estoque\Controller\index' => 'Estoque\Controller\IndexController',
			'Estoque\Controller\usuario' => 'Estoque\Controller\UsuarioController',
		)
	),
	
	'view_manager' => array(
		'template_path_stack' => array (
			__DIR__.'/../view/',
		), 

		'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
	),

	'view_helpers' => array(
		'invokables' => array(
			'FlashHelper' => 'Estoque\Helper\View\FlashHelper',
			'PaginationHelper' => 'Estoque\Helper\View\PaginationHelper'
		),
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

     'authentication' => array (
        	'orm_default' => array (
        		'object_manager' => 'Doctrine\ORM\EntityManager',
        		'identity_class' => 'Estoque\Entity\Usuario',
        		'identity_property' => 'email',
        		'credential_property' => 'senha',
        		'credentialCallable' => function ($user, $senha) {
        			return $user->getSenha() == md5($senha);
        		}
        	)
        ), 
    ),
);