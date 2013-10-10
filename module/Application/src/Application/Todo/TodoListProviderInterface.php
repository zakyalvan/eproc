<?php
namespace Application\Todo;

use Zend\Paginator\Paginator;
use Application\Common\SearchableListProviderInterface;

/**
 * Base interface untuk todo list data provider.
 * 
 * @author zakyalvan
 */
interface TodoListProviderInterface extends SearchableListProviderInterface {}