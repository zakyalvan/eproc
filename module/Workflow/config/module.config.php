<?php
namespace Workflow;

use Workflow\Execution\Handler\Service\TransitionHandlerRegistryFactory;
use Workflow\Execution\Evaluator\Service\SplitEvaluatorRegistryFactory;

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
		'abstract_factories' => array(
			'Workflow\Execution\Handler\Service\TransitionHandlerAbstractFactory',
			'Workflow\Execution\Evaluator\Service\SplitEvaluatorAbstractFactory'
		),
		'factories' => array(
			'Workflow\Execution\Handler\Service\TransitionHandlerRegistry' => 'Workflow\Execution\Handler\Service\TransitionHandlerRegistryFactory',
			'Workflow\Execution\Evaluator\Service\SplitEvaluatorRegistry' => 'Workflow\Execution\Evaluator\Service\SplitEvaluatorRegistryFactory'
		),
		'invokables' => array(
			'Workflow\Definition\DefinitionServiceInterface' => 'Workflow\Definition\DefinitionService',
			'Workflow\Execution\ExecutionServiceInterface' => 'Workflow\Execution\ExecutionService',
			'Workflow\Execution\Router\ProcessRouter' => 'Workflow\Router\ProcessRouter',
			'Workflow\Execution\WorkitemManager' => 'Workflow\Execution\WorkitemManager'
		)
	),
	'workflow' => array(
		TransitionHandlerRegistryFactory::DEFAULT_REGISTRY_CONFIG_KEY => array(
			
		),
		SplitEvaluatorRegistryFactory::DEFAULT_REGISTRY_CONFIG_KEY => array(
			
		)
	)
);