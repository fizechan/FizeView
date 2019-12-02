<?php


namespace fize\view\handler;

use fize\view\ViewHandler;

/**
 * Zend
 * @see https://zendframework.github.io/zend-view/php-renderer/
 */
class Zend implements ViewHandler
{

    /**
     * @inheritDoc
     */
    public function __construct(array $config = [])
    {
    }

    /**
     * @inheritDoc
     */
    public function engine()
    {
        // TODO: Implement engine() method.
    }

    /**
     * @inheritDoc
     */
    public function assign($name, $value)
    {
        // TODO: Implement assign() method.
    }

    /**
     * @inheritDoc
     */
    public function render($path, array $assigns = [])
    {
        // TODO: Implement render() method.
    }

    /**
     * @inheritDoc
     */
    public function display($path, array $assigns = [])
    {
        // TODO: Implement display() method.
    }
}