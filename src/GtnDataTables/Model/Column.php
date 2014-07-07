<?php
namespace GtnDataTables\Model;

use GtnDataTables\Exception\MissingConfigurationException;
use GtnDataTables\Exception\UnexpectedValueException;
use GtnDataTables\View\AbstractDecorator;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

class Column
{
    /** @var AbstractDecorator */
    protected $decorator;

    /** @var string $key */
    protected $key;

    /**
     * @param AbstractDecorator $decorator
     * @param string $key
     */
    public function __construct(AbstractDecorator $decorator = null, $key = null)
    {
        $this->setDecorator($decorator);
        $this->setKey($key);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param array                   $config
     * @return Column
     * @throws \GtnDataTables\Exception\MissingConfigurationException
     * @throws \GtnDataTables\Exception\UnexpectedValueException
     */
    public static function factory(ServiceLocatorInterface $serviceLocator, $config = array())
    {
        if (empty($config)) {
            throw new MissingConfigurationException('Unable to create Column: configuration is missing');
        }

        $decoratorClass = $config['decorator'];
        $decorator = new $decoratorClass;
        if (! $decorator instanceof AbstractDecorator) {
            throw new UnexpectedValueException("Unable to create Column: $decoratorClass should extend GtnDataTables\\View\\AbstractDecorator");
        }

        /** @var HelperPluginManager $viewHelperManager */
        $viewHelperManager = $serviceLocator->get('ViewHelperManager');
        $decorator->setViewHelperManager($viewHelperManager);

        /** @var PluginManager $controllerPluginManager */
        $controllerPluginManager = $serviceLocator->get('ControllerPluginManager');
        $decorator->setControllerPluginManager($controllerPluginManager);

        $column = new Column($decorator);
        $column->setKey(isset($config['key']) ? $config['key'] : null);

        return $column;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getDecorator()->decorateTitle();
    }

    /**
     * @param Object $object
     * @return string
     */
    public function getValue($object)
    {
        return $this->getDecorator()->decorateValue($object);
    }

    /**
     * Get Decorator.
     *
     * @return AbstractDecorator
     */
    public function getDecorator()
    {
        return $this->decorator;
    }

    /**
     * Set Decorator.
     *
     * @param AbstractDecorator $decorator
     * @return Column
     */
    public function setDecorator($decorator)
    {
        $this->decorator = $decorator;
        return $this;
    }

    /**
     * Get Key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set Key.
     *
     * @param string $key
     * @return Column
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
}
