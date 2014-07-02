<?php
namespace GtnDataTablesTest\View;

use GtnDataTables\View\AbstractDecorator;
use GtnDataTablesTest\Model\Server;

class ServerNameDecorator extends AbstractDecorator
{
    /**
     * @return string
     */
    public function decorateTitle()
    {
        return 'Server';
    }

    /**
     * @param Server $object
     * @return string
     */
    public function decorateValue($object)
    {
        return '<strong>' . $object->getName() . '</strong>';
    }
}
