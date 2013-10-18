<?php 
namespace Contract;

use Contract\Service\AbstractContractListProvider;

/**
 * Konfigurasi untuk modul contract
 */
return array(
	'controllers' => array(
		'invokables' => array(
			'Contract\Controller\Init' => 'Contract\Controller\InitController',
			'Contract\Controller\Index' => 'Contract\Controller\IndexController',
			'Contract\Controller\Todo' => 'Contract\Controller\TodoController',
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
							'route' => '/:controller[/:action]',
							'defaults' => array(
								'__NAMESPACE__' => 'Contract\Controller',
								'controller' => 'index',
								'action' => 'index'
							)
						)
					),
					'todo' => array(
						'type' => 'Zend\Mvc\Router\Http\Segment',
						'options' => array(
							'route' => '/todo[/data/:action[/:page[/:rows]]]',
							'constraints' => array(
								'action' => '[\\.a-zA-Z0-9_-]+',
								'page' => '[0-9]+',
								'rows' => '[0-9]+'
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Contract\Controller',
								'controller' => 'todo',
								'action' => 'index',
								'page' => 1,
								'rows' => 10
							)
						)
					),
					'init' => array(
						'type' => 'Zend\Mvc\Router\Http\Segment',
						'options' => array(
							'route' => '/init/assign/:kantor/:tender',
							'constraints' => array(
								'tender' => '[\\.a-zA-Z0-9_-]+',
								'kantor' => '[a-zA-Z0-9]+'
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Contract\Controller',
								'controller' => 'init',
								'action' => 'assign'
							)
						)
					),
					'create' => array(
						'type' => 'Zend\Mvc\Router\Http\Segment',
						'options' => array(
							'route' => '/create/:action/:kantor/:tender',
							'constraints' => array(
								'tender' => '[\\.a-zA-Z0-9_-]+',
								'kantor' => '[a-zA-Z0-9]+'
							),
							'defaults' => array(
								'__NAMESPACE__' => 'Contract\Controller',
								'controller' => 'create',
								'action' => 'index'
							)
						)
					)
				)
			)
		)
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Manajemen Kontrak',
				'route' => 'contract',
				'class' => 'sub',
				'pages' => array(
					array(
						'label' => 'Daftar Pekerjaan',
						'route' => 'contract/default',
						'controller' => 'todo',
						'action' => 'index'
					),
					array(
						'label' => 'Pembuatan Work Order',
						'route' => 'contract/default',
						'controller' => 'satuan',
						'action' => 'index'
					),
					array(
						'label' => 'Monitor',
						'route' => 'contract',
						'class' => 'sub',
						'pages' => array(
							array(
								'label' => 'Monitor Kontrak',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Work Order',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Progress Work Order',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Progress Milestone',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Progress Termin',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Adendum Kontrak',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							),
							array(
								'label' => 'Monitor Tagihan',
								'route' => 'contract/default',
								'controller' => 'index',
								'action' => 'index'
							)
						)
					),
					array(
						'label' => 'Panduan',
						'route' => 'contract/default',
						'controller' => 'satuan',
						'action' => 'index'
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
	'service_manager' => array(
		'abstract_factories' => array(
			'Contract\Service\Factory\ContractListProviderAbstractFactory'
		),
		'invokables' => array(
			'Contract\Service\InitiateService' => 'Contract\Service\InitiateService',
			'Contract\Service\ContractService' => 'Contract\Service\ContractService',
			'Contract\Service\WorkOrderService' => 'Contract\Service\WorkOrderService'
		)
	),
	'contract' => array(
		'list_providers' => array(
			AbstractContractListProvider::KONTRAK_HARGA_SATUAN_LIST_PROVIDER => 'Contract\Service\HargaSatuanContractListProvider'
		)
	),
	'todo_list' => array(
		'providers' => array(
			'Contract\Todo\ContractInit' => 'Contract\Todo\ContractInitTodoListProvider',
			'Contract\Todo\ContractCreate' => 'Contract\Todo\ContractCreateTodoListProvider',
			'Contract\Todo\ContractAmend' => 'Contract\Todo\ContractAmendTodoListProvider',
			'Contract\Todo\WorkOrder' => 'Contract\Todo\WorkOrderTodoListProvider'
		)
	),
	'workflow' => array(
		'transition_handlers' => array(
			
		),
		'split_evaluators' => array(
			'create\JenisKontrakEvaluator' => 'Contract\Workflow\Evaluator\Create\JenisKontrakSplitEvaluator',
			'create\PersetujuanAtasanEvaluator' => 'Contract\Workflow\Evaluator\Create\PersetujuanAtasanUserSplitEvaluator'
		)
	)
);