<?php
namespace Workflow;

return array(
	'controllers' => array(
		'invokables' => array(
			'Workflow\Controller\Workflow' => 'Workflow\Controller\WorkflowController',
			'Workflow\Controller\Transition' => 'Workflow\Controller\TransitionController',
			'Workflow\Controller\Place' => 'Workflow\Controller\PlaceController',
			'Workflow\Controller\Arc' => 'Workflow\Controller\ArcController',
		)
	),
	'router' => array(
		'routes' => array(
			'workflow' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/workflow[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Workflow\Controller\Workflow',
						'action' => 'index'
					)
				)
			),
			'place' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/workflow/place[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Workflow\Controller\Place',
						'action' => 'index'
					)
				)
			),
			'transition' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/workflow/transition[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Workflow\Controller\Transition',
						'action' => 'index'
					)
				)
			),
			'arc' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/workflow/arc[/:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					),
					'defaults' => array(
						'controller' => 'Workflow\Controller\Arc',
						'action' => 'index'
					)
				)
			)
		)	
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'workflow' => __DIR__ . '/../view'
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
		'factories' => array(
			'Workflow\Service\DefinitionService' => function($serviceManager) {
				$entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
				$service = new DefaultDefinitionService($entityManager);
				return $service;
			}
		),
		'invokables' => array(
			'Workflow\Execution\Manager\InstanceManager' => 'Workflow\Manager\InstanceManager',
			'Workflow\Execution\Router\TokenRouter' => 'Workflow\Router\TokenRouter'
		)
	),
	'workflow' => array(
		'transition_handlers' => array(
			
		)
	)
);