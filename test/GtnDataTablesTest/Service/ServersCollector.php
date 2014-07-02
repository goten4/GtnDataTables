<?php
namespace GtnDataTablesTest\Service;

use GtnDataTables\Model\Collection;
use GtnDataTables\Service\CollectorInterface;
use GtnDataTablesTest\Model\Server;

class ServersCollector implements CollectorInterface
{
    /** @var array */
    protected $servers;

    public function __construct()
    {
        $this->servers = array(
            new Server('node1.local'),
            new Server('node2.local'),
            new Server('node3.local'),
            new Server('node4.local'),
            new Server('node5.local'),
            new Server('node6.local'),
            new Server('node7.local'),
            new Server('node8.local'),
            new Server('node9.local'),
            new Server('node10.local'),
            new Server('node11.local'),
            new Server('node12.local'),
        );
    }

    /**
     * @param int    $start
     * @param int    $length
     * @param string $search
     * @param array  $order
     * @return array
     */
    public function findAll($start = null, $length = null, $search = null, $order = null)
    {
        $servers = array();
        foreach ($this->servers as $server) {
            if ($search === null || preg_match('/' . $search . '/', $server->getName())) {
                $servers[] = $server;
            }
        }
        $total = count($servers);
        return Collection::factory(array_slice($servers, $start, $length), $total, $total);
    }
}
