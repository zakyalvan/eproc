<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
	'db' => array(
		'driver' => 'OCI8',
		'hostname' => '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))(CONNECT_DATA=(SID=xe)))',
		'character_set' => 'AL32UTF8',
		'username' => 'EP',
		'password' => 'welcome_1'
	),
	'doctrine' => array(
		'connection' => array(
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\OCI8\Driver',
				'params' => array(
					'host'     => 'localhost',
					'port'     => '1521',
					'user'     => 'EP',
					'password' => 'welcome_1',
					'dbname'   => 'xe',
					'pooled'   => true,
					'charset'  => 'AL32UTF8'
				)
			)
		),
		// Init oracle session, listener ini (nge-force) agar (beberapa) type data balikan dari oracle sesuai harapan doctrine.
		'eventmanager' => array(
			'orm_default' => array(
				'subscribers' => array(
					'Doctrine\DBAL\Event\Listeners\OracleSessionInit'
				)
			)
		)
	),
 	'session_config' => array(
		
 	),
	'session_manager' => array(
		
	),
	'todo_list' => array(),
	'service_manager' => array(
		'initializers' => array(
			'Application\Common\Service\InitializableObjectInitializer',
			'Application\Common\Service\ObjectManagerAwareInitializer',
			'Application\Common\Service\IdentityAwareInitializer'
		),
		'abstract_factories' => array(
			'Application\Todo\Service\TodoListProviderAbstractFactory'
		),
		'factories' => array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
			'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
			'Zend\Session\SessionManager' => 'Zend\Session\Service\SessionManagerFactory',
			'Zend\Authentication\AuthenticationService' => function($serviceManager) {
				return $serviceManager->get('doctrine.authenticationservice.orm_default');
			}
		)
	)
);
