<?php
namespace GtnDataTablesTest\Model;

use GtnDataTables\Model\Column;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    protected $serviceManager;

    protected function setUp()
    {
        $this->serviceManager = new ServiceManager(new ServiceManagerConfig(array(
            'factories' => array(
                'ViewHelperManager' => 'Zend\Mvc\Service\ViewHelperManagerFactory',
            ),
        )));
        $this->serviceManager->setService('Config', array());
    }

    /**
     * @test
     * @expectedException \GtnDataTables\Exception\MissingConfigurationException
     * @expectedExceptionMessage Unable to create Column: configuration is missing
     */
    public function cannotCreateColumnWithEmptyConfiguration()
    {
        Column::factory($this->serviceManager, array());
    }

    /**
     * @test
     * @expectedException \GtnDataTables\Exception\UnexpectedValueException
     * @expectedExceptionMessage Unable to create Column: GtnDataTablesTest\View\InvalidDecorator should extend GtnDataTables\View\AbstractDecorator
     */
    public function cannotCreateColumnWithInvalidDecorator()
    {
        Column::factory($this->serviceManager, array(
            'decorator' => 'GtnDataTablesTest\View\InvalidDecorator'
        ));
    }

    /** @test */
    public function canCreateColumnWithValidConfiguration()
    {
        $column = Column::factory($this->serviceManager,  array(
            'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
            'key' => 'name',
        ));

        $this->assertInstanceOf('GtnDataTables\Model\Column', $column);
        $this->assertInstanceOf('GtnDataTables\View\AbstractDecorator', $column->getDecorator());
        $this->assertInstanceOf('Zend\ServiceManager\AbstractPluginManager', $column->getDecorator()->getViewHelperManager());
        $this->assertEquals('name', $column->getKey());
    }

    /** @test */
    public function canCreateColumnWithoutKey()
    {
        $column = Column::factory($this->serviceManager,  array(
            'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
        ));

        $this->assertNull($column->getKey());
    }

    /** @test */
    public function canGetTitle()
    {
        $column = Column::factory($this->serviceManager,  array(
            'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
        ));

        $this->assertEquals('Server', $column->getTitle());
    }

    /** @test */
    public function canGetValue()
    {
        $column = Column::factory($this->serviceManager,  array(
            'decorator' => 'GtnDataTablesTest\View\ServerNameDecorator',
        ));

        $this->assertEquals('<strong>node1.local</strong>', $column->getValue(new Server('node1.local')));
    }
}
