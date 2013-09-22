<?php
namespace Vendor;

return array(
	'controllers' => array(
		'invokables' => array(
			'Vendor\Controller\Index' => 'Vendor\Controller\IndexController',
			'Vendor\Controller\Register' => 'Vendor\Controller\RegisterController',
			'Vendor\Controller\Auth' => 'Vendor\Controller\AuthController'
		)
	),
	'router' => array(
		'routes' => array(
			'vendor' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/vendor',
					'defaults' => array(
						'__NAMESPACE__' => 'Vendor\Controller',
						'controller' => 'Index',
						'action' => 'index'
					)
				),
				'may_terminate' => true,
				'child_routes' => array(
					'login' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/login',
							'defaults' => array(
								'__NAMESPACE__' => 'Vendor\Controller',
								'controller' => 'Auth',
								'action' => 'login'
							)
						)
					),
					'logout' => array(
						'type' => 'Zend\Mvc\Router\Http\Literal',
						'options' => array(
							'route' => '/logout',
							'defaults' => array(
								'__NAMESPACE__' => 'Vendor\Controller',
								'controller' => 'Auth',
								'action' => 'logout'
							)
						)
					),
				)
			)
		)
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'template_path_stack' => array(
			__DIR__ . '/../view',
		)
	),
	'service_manager' => array(
		'factories' => array()
	),
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
				)
			),
			'orm_default' => array (
				'drivers' => array (
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				)
			)
		)
	)
);