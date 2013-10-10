<?php
namespace Application\Todo;

use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Common\AbstractListProvider;

/**
 * Implementasi dasar dari {@link TodoListProviderInterface}.
 * Doctrine base dan harus diinisiasi dalam service locator atau supply manual object {@link ServiceLocatorInterface}
 * 
 * @author zakyalvan
 */
abstract class AbstractTodoListProvider extends AbstractListProvider implements TodoListProviderInterface {

}