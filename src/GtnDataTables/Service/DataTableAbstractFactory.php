<?php
namespace GtnDataTables\Service;

use GtnDataTables\Exception\MissingConfigurationException;
use GtnDataTables\Model\Column;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DataTableAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Configuration key for datatables
     *
     * @var string
     */
    protected $configKey = 'datatables';

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator);
        if (empty($config)) {
            return false;
        }

        return (isset($config[$requestedName]) && is_array($config[$requestedName]));
    }

    /**
     * Create service with name
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     * @return mixed
     * @throws MissingConfigurationException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $config = $this->getConfig($serviceLocator);
        $config = $config[$requestedName];

        if (!isset($config['collectorFactory'])) {
            throw new MissingConfigurationException('Unable to create DataTable service: collectorFactory is missing');
        }

        if (!isset($config['columns']) || empty($config['columns'])) {
            throw new MissingConfigurationException('Unable to create DataTable service: columns are missing');
        }

        /** @var FactoryInterface $collectorFactory */
        $collectorFactory = new $config['collectorFactory'];

        $datatable = new DataTable(isset($config['id']) ? $config['id'] : $requestedName);
        $datatable->setCollector($collectorFactory->createService($serviceLocator));
        $columns = array();
        foreach ($config['columns'] as $columnConfig) {
            $columns[] = Column::factory($serviceLocator, $columnConfig);
        }
        $datatable->setColumns($columns);
        if (isset($config['classes'])) {
            $datatable->setClasses($config['classes']);
        }

        return $datatable;
    }

    /**
     * Retrieve repositories configuration, if any
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return array
     */
    protected function getConfig(ServiceLocatorInterface $serviceLocator)
    {
        if ($this->config !== null) {
            return $this->config;
        }

        if (!$serviceLocator->has('Config')) {
            $this->config = array();
            return $this->config;
        }

        $config = $serviceLocator->get('Config');
        if (!isset($config[$this->configKey])) {
            $this->config = array();
            return $this->config;
        }

        $this->config = $config[$this->configKey];
        return $this->config;
    }
}
