<?php
namespace GtnDataTables\View;

use Zend\Mvc\Controller\PluginManager;
use Zend\View\HelperPluginManager;

abstract class AbstractDecorator
{
    /** @var HelperPluginManager */
    protected $viewHelperManager;

    /** @var PluginManager */
    protected $controllerPluginManager;

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
     * @return HelperPluginManager
     */
    public function getViewHelperManager()
    {
        return $this->viewHelperManager;
    }

    /**
     * Set ViewHelperManager.
     *
     * @param HelperPluginManager $viewHelperManager
     * @return AbstractDecorator
     */
    public function setViewHelperManager($viewHelperManager)
    {
        $this->viewHelperManager = $viewHelperManager;
        return $this;
    }

    /**
     * Get controller plugin manager
     *
     * @return PluginManager
     */
    public function getControllerPluginManager()
    {
        return $this->controllerPluginManager;
    }

    /**
     * Set controller plugin manager
     *
     * @param  PluginManager $controllerPluginManager
     * @return AbstractDecorator
     */
    public function setControllerPluginManager(PluginManager $controllerPluginManager)
    {
        $this->controllerPluginManager = $controllerPluginManager;
        return $this;
    }

    /**
     * Get plugin instance
     *
     * @param  string $name Name of plugin to return
     * @return mixed
     */
    public function plugin($name)
    {
        $plugin = $this->getViewHelperManager()->get($name);
        if ($plugin !== null) {
            return $this->getViewHelperManager()->get($name);
        }
        return $this->getControllerPluginManager()->get($name);
    }

    /**
     * @param       $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments = array())
    {
        $plugin = $this->plugin($name);
        if (is_callable($plugin)) {
            return call_user_func_array($plugin, $arguments);
        }

        return $plugin;
    }
}
