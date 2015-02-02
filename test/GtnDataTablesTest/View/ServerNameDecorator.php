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
     * @param $context
     * @return string
     */
    public function decorateValue($object, $context = null)
    {
        return '<strong>' . $object->getName() . '</strong>';
    }
}
