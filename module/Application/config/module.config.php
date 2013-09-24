<?php
namespace Application;

use Application\Entity\User;

/**
 * Konfigurasi untuk module Application.
 */
return array(
	'controllers' => array(
		'invokables' => array(
			'Application\Controller\Index' => 'Application\Controller\IndexController',
			'Application\Controller\Auth' => 'Application\Controller\AuthController'
		),
	),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'login' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route' => '/login',
        			'defaults' => array(
        				'controller' => 'Application\Controller\Auth',
        				'action' => 'login'
        			)
        		)
			),
			'logout' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route' => '/logout',
        			'defaults' => array(
        				'controller' => 'Application\Controller\Auth',
        				'action' => 'logout'
        			)
        		)
			)  
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/default.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        )
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
    	),
    	'authentication' => array(
    		'orm_default' => array(
    			'object_manager' => 'Doctrine\ORM\EntityManager',
    			'identity_class' => 'Application\Entity\User',
    			'identity_property' => 'usercode',
    			'credential_property' => 'password',
    			/**
    			 * Ini callable function untuk ngebandingin password yang diberikan dengan password yang tersimpan
    			 * dalam database. Callable ini digunakan dalam kelas auth adapter bawaan doctrine-module.
    			 * 
    			 * @see https://github.com/doctrine/DoctrineModule/blob/master/docs/authentication.md
    			 */
    			'credential_callable' => function(User $user, $passwordGiven) {
    				return true;
    			}
    		),
    	)
    )
);
