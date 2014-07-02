<?php
namespace GtnDataTablesTest\Model;

use GtnDataTables\Model\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    protected $data;

    protected function setUp()
    {
        $this->data = array(new Server('node1.local'), new Server('node2.local'));
    }

    /** @test */
    public function canCreateCollection()
    {
        $collection = Collection::factory($this->data, 10, 8);

        $this->assertInstanceOf('GtnDataTables\Model\Collection', $collection);
        $this->assertEquals($this->data, $collection->getData());
        $this->assertEquals(10, $collection->getTotal());
        $this->assertEquals(8, $collection->getFilteredCount());
    }

    /** @test */
    public function canIterateOnCollection()
    {
        $collection = Collection::factory($this->data, 10);

        $serversNames = array();
        foreach ($collection as $server) {
            /** @var Server $server */
            $serversNames[] = $server->getName();
        }
        $collection->rewind();

        $this->assertEquals(array('node1.local', 'node2.local'), $serversNames);
        $this->assertEquals(0, $collection->key());
    }

    /** @test */
    public function canCountCollection()
    {
        $collection = Collection::factory($this->data, 10);

        $this->assertEquals(2, count($collection));
    }

    /** @test */
    public function canGetByIndex()
    {
        $collection = Collection::factory($this->data);

        $this->assertEquals($this->data[1], $collection->get(1));
    }
}
