<?php
namespace GtnDataTables\Service;

use GtnDataTables\Model\Collection;

interface CollectorInterface
{
    /**
     * @param array $params
     * @return Collection
     */
    public function findAll(array $params = null);
}
