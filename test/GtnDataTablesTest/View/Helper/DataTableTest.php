<?php
namespace GtnDataTablesTest\View\Helper;

use GtnDataTables\Model\Column;
use GtnDataTables\View\Helper;
use GtnDataTablesTest\View\ServerActionsDecorator;
use GtnDataTablesTest\View\ServerNameDecorator;

class DataTableTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function canRenderDataTable()
    {
        $helper = new Helper\DataTable();

        $result = $helper(
            array(
                new Column(new ServerNameDecorator(), 'name'),
                new Column(new ServerActionsDecorator())),
            'servers',
            array('class1', 'class2')
        );

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
