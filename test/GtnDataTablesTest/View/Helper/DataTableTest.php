<?php
namespace GtnDataTablesTest\View\Helper;

use GtnDataTables\Model\Column;
use GtnDataTables\Service;
use GtnDataTables\View\Helper;
use GtnDataTablesTest\View\ServerActionsDecorator;
use GtnDataTablesTest\View\ServerNameDecorator;
use Zend\View\HelperPluginManager;

class DataTableTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canRenderDataTable()
    {
        $datatable = new Service\DataTable(
            'servers',
            null,
            array(
                new Column(new ServerNameDecorator(), 'name'),
                new Column(new ServerActionsDecorator())
            ),
            array('class1', 'class2')
        );
        $serviceManager = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceManager->expects($this->any())
            ->method('get')
            ->with('servers_datatable')
            ->will($this->returnValue($datatable));
        $helperPluginManager = new HelperPluginManager();
        $helperPluginManager->setServiceLocator($serviceManager);
        $helper = new Helper\DataTable();
        $helper->setServiceLocator($helperPluginManager);

        $result = $helper('servers_datatable')->renderHtml();

        $expectedResult = <<<'EOD'
<table class="class1 class2" id="servers">
    <thead>
        <tr>
            <th>Server</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>
EOD;
        $this->assertEquals($expectedResult, $result);
    }
}
