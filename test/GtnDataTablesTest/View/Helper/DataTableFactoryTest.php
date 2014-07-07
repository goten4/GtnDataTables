<?php
namespace GtnDataTablesTest\View\Helper;

use GtnDataTables\View\Helper\DataTableFactory;
use Zend\ServiceManager\ServiceManager;

class DataTableFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canCreateService()
    {
        $factory = new DataTableFactory();
        $serviceLocator = new ServiceManager();

        $service = $factory->createService($serviceLocator);

        $this->assertInstanceOf('GtnDataTables\View\Helper\DataTable', $service);
        $this->assertSame($serviceLocator, $service->getServiceLocator());
    }
}
