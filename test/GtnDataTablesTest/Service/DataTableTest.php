<?php
namespace GtnDataTablesTest\Service;

use GtnDataTables\Model\Column;
use GtnDataTables\Service;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class DataTableTest extends \PHPUnit_Framework_TestCase
{
    /** @var Service\DataTable */
    protected $service;

    protected function setUp()
    {
        $this->service = new Service\DataTable();
        $this->service->setCollector(new ServersCollector());
        $this->service->setColumns(array(
            Column::factory($this->getServiceManager(), array(
                'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
                'key' => 'name',
            )),
            Column::factory($this->getServiceManager(), array(
                'decorator' => 'GtnDataTablesTest\View\ServerActionsDecorator',
            )),
        ));
    }

    /** @test */
    public function canCreateWithSearch()
    {
        $datatable = $this->service->create(array(
            'draw' => 8,
            'start' => 0,
            'length' => 5,
            'search' => array(
                'value' => 'node[2-9]',
            ),
        ));

        $this->assertInstanceOf('GtnDataTables\Model\DataTable', $datatable);
        $this->assertEquals(array(
            array('<strong>node2.local</strong>', '<a href="/servers/node2.local/delete">delete</a>'),
            array('<strong>node3.local</strong>', '<a href="/servers/node3.local/delete">delete</a>'),
            array('<strong>node4.local</strong>', '<a href="/servers/node4.local/delete">delete</a>'),
            array('<strong>node5.local</strong>', '<a href="/servers/node5.local/delete">delete</a>'),
            array('<strong>node6.local</strong>', '<a href="/servers/node6.local/delete">delete</a>'),
        ), $datatable->getData());
        $this->assertEquals(8, $datatable->getDraw());
        $this->assertEquals(8, $datatable->getRecordsFiltered());
        $this->assertEquals(8, $datatable->getRecordsTotal());
    }

    /**
     * @return ServiceManager
     */
    protected function getServiceManager()
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig(array(
            'factories' => array(
                'ViewHelperManager' => 'Zend\Mvc\Service\ViewHelperManagerFactory',
            ),
        )));
        $serviceManager->setService('Config', array());

        return $serviceManager;
    }
}
