<?php 
namespace Contract;

return array(
	'controllers' => array(
		'invokables' => array(
			'Contract\Controller\Index' => 'Contract\Controller\IndexController',
			'Contract\Controller\Amend' => 'Contract\Controller\AmendController',
			'Contract\Controller\Close' => 'Contract\Controller\CloseController',
			'Contract\Controller\Create' => 'Contract\Controller\CreateController',
			'Contract\Controller\Invoice' => 'Contract\Controller\InvoiceController',
			'Contract\Controller\Monitor' => 'Contract\Controller\MonitorController',
			'Contract\Controller\Satuan' => 'Contract\Controller\SatuanController'
		)
	),
	'router' => array(
		'routes' => array(
			'contract' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/contract',
					'defaults' => array(
						'__NAMESPACE__' => 'Contract\Controller',
						'controller' => 'Index',
						'action' => 'index'
					)
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type' => 'Zend\Mvc\Router\Http\Segment',
						'options' => array(
							'route' => '/contract[/:controller[/:action[/:id]]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]+'
							)
						),
						'defaults' => array()
					)
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
    ),
	'todo_list' => array(
		'providers' => array(
			'Contract\Todo\ContractInit' => 'Contract\Todo\ContractInitTodoListProvider',
			'Contract\Todo\ContractCreate' => 'Contract\Todo\ContractCreateTodoListProvider',
			'Contract\Todo\ContractAmend' => 'Contract\Todo\ContractAmendTodoListProvider',
			'Contract\Todo\WorkOrder' => 'Contract\Todo\WorkOrderTodoListProvider'
		)
	)
);