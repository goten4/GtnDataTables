<?php
namespace GtnDataTables\View;

use Zend\ServiceManager\AbstractPluginManager;

abstract class AbstractDecorator
{
    /**
     * @var AbstractPluginManager
     */
    protected $viewHelperManager;

    /**
     * @return string
     */
    abstract public function decorateTitle();

    /**
     * @param $object
     * @return string
     */
    abstract public function decorateValue($object);

    /**
     * Get ViewHelperManager.
     *
     * @return \Zend\ServiceManager\AbstractPluginManager
     */
    public function getViewHelperManager()
    {
        return $this->viewHelperManager;
    }

    /**
     * Set ViewHelperManager.
     *
     * @param \Zend\ServiceManager\AbstractPluginManager $viewHelperManager
     * @return AbstractDecorator
     */
    public function setViewHelperManager($viewHelperManager)
    {
        $this->viewHelperManager = $viewHelperManager;
        return $this;
    }
}
