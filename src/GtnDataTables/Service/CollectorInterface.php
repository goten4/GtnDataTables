<?php
namespace GtnDataTables\Service;

use GtnDataTables\Model\Collection;

interface CollectorInterface
{
    /**
     * @param int $start
     * @param int $length
     * @param string $search
     * @param array $order
     * @return Collection
     */
    public function findAll($start = null, $length = null, $search = null, $order = null);
}
