<?php
namespace GtnDataTablesTest\Service;

use GtnDataTables\Service\DataTable;
use GtnDataTables\Service\DataTableAbstractFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class DataTableAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataTableAbstractFactory
     */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new DataTableAbstractFactory();
    }

    /** @test */
    public function canCreateServiceShouldReturnFalseForUnknownDataTable()
    {
        $serviceManager = $this->getServiceManager(array(
            'datatables' => array(),
        ));

        $this->assertFalse($this->factory->canCreateServiceWithName($serviceManager, 'unknown', 'unknown'));
    }

    /** @test */
    public function canCreateServiceShouldReturnTrueForValidDataTable()
    {
        $serviceManager = $this->getServiceManager($this->getValidConfig());

        $this->assertTrue($this->factory->canCreateServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable'));
    }

    /** @test */
    public function canCreateServiceShouldReturnFalseIfNoDatatablesEntriesInConfig()
    {
        $serviceManager = $this->getServiceManager(array());

        $this->assertFalse($this->factory->canCreateServiceWithName($serviceManager, 'unknown', 'unknown'));
    }

    /** @test */
    public function canCreateServiceShouldReturnFalseIfNoConfig()
    {
        $serviceManager = $this->getServiceManager(null);

        $this->assertFalse($this->factory->canCreateServiceWithName($serviceManager, 'whocares', 'whocares'));
    }

    /** @test */
    public function canCreateServiceShouldReturnFalseIfDatatablesEntryIsNotAnArray()
    {
        $serviceManager = $this->getServiceManager(array('datatables' => ''));

        $this->assertFalse($this->factory->canCreateServiceWithName($serviceManager, 'whocares', 'whocares'));
    }

    /** @test */
    public function canCreateServiceWithName()
    {
        $serviceManager = $this->getServiceManager($this->getValidConfig());

        /** @var DataTable $service */
        $service = $this->factory->createServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable');

        $this->assertInstanceOf('GtnDataTables\Service\DataTable', $service);
        $this->assertEquals('servers', $service->getId());
        $this->assertInstanceOf('GtnDataTablesTest\Service\ServersCollector', $service->getCollector());
        $columns = $service->getColumns();
        $this->assertEquals(2, count($columns));
        $firstColumn = $columns[0];
        $this->assertInstanceOf('GtnDataTables\Model\Column', $firstColumn);
        $this->assertEquals(array('table'), $service->getClasses());
    }

    /** @test */
    public function canCreateServiceWithNameWithoutIdNorClasses()
    {
        $serviceManager = $this->getServiceManager(array(
            'datatables' => array(
                'servers_datatable' => array(
                    'collectorFactory' => 'GtnDataTablesTest\Service\ServersCollectorFactory',
                    'columns' => array(
                        array(
                            'decorator' => 'GtnDataTablesTest\View\ServerActionsDecorator',
                            'title' => 'Actions',
                        ),
                    )
                ),
            ),
        ));

        /** @var DataTable $service */
        $service = $this->factory->createServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable');

        $this->assertEquals('servers_datatable', $service->getId());
        $this->assertNull($service->getClasses());
    }

    /**
     * @test
     * @expectedException \GtnDataTables\Exception\MissingConfigurationException
     * @expectedExceptionMessage Unable to create DataTable service: collectorFactory is missing
     */
    public function cannotCreateServiceWithoutCollectorFactory()
    {
        $serviceManager = $this->getServiceManager(array(
            'datatables' => array(
                'servers_datatable' => array(
                    'columns' => array(
                        array(
                            'decorator' => 'GtnDataTablesTest\View\ServerActionsDecorator',
                            'title' => 'Actions',
                        ),
                    )
                ),
            ),
        ));

        $this->factory->createServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable');
    }

    /**
     * @test
     * @expectedException \GtnDataTables\Exception\MissingConfigurationException
     * @expectedExceptionMessage Unable to create DataTable service: columns are missing
     */
    public function cannotCreateServiceWithoutColumns()
    {
        $serviceManager = $this->getServiceManager(array(
            'datatables' => array(
                'servers_datatable' => array(
                    'collectorFactory' => 'GtnDataTablesTest\Service\ServersCollectorFactory',
                ),
            ),
        ));

        $this->factory->createServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable');
    }

    /**
     * @test
     * @expectedException \GtnDataTables\Exception\MissingConfigurationException
     * @expectedExceptionMessage Unable to create DataTable service: columns are missing
     */
    public function cannotCreateServiceWithEmptyColumns()
    {
        $serviceManager = $this->getServiceManager(array(
            'datatables' => array(
                'servers_datatable' => array(
                    'collectorFactory' => 'GtnDataTablesTest\Service\ServersCollectorFactory',
                    'columns' => array(),
                ),
            ),
        ));

        $this->factory->createServiceWithName($serviceManager, 'servers_datatable', 'servers_datatable');
    }

    /**
     * @param array $config
     * @return ServiceManager
     */
    protected function getServiceManager(array $config = null)
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig(array(
            'factories' => array(
                'ViewHelperManager' => 'Zend\Mvc\Service\ViewHelperManagerFactory',
            ),
            'abstract_factories' => array(
                'GtnDataTables\Service\DataTableAbstractFactory',
            ),
        )));
        if ($config !== null) {
            $serviceManager->setService('Config', $config);
        }
        return $serviceManager;
    }

    /**
     * @return array
     */
    protected function getValidConfig()
    {
        return array(
            'datatables' => array(
                'servers_datatable' => array(
                    'id' => 'servers',
                    'classes' => array('table'),
                    'collectorFactory' => 'GtnDataTablesTest\Service\ServersCollectorFactory',
                    'columns' => array(
                        array(
                            'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
                            'key' => 'name',
                            'title' => 'Server',
                        ),
                        array(
                            'decorator' => 'GtnDataTablesTest\View\ServerActionsDecorator',
                            'title' => 'Actions',
                        ),
                    )
                ),
            ),
        );
    }
}
