<?php
namespace GtnDataTablesTest\View;

use GtnDataTables\View\AbstractDecorator;
use GtnDataTablesTest\Model\Server;

class ServerActionsDecorator extends AbstractDecorator
{
    /**
     * @return string
     */
    public function decorateTitle()
    {
        return 'Actions';
    }

    /**
     * @param Server $object
     * @return string
     */
    public function decorateValue($object)
    {
        return '<a href="/servers/' . $object->getName() . '/delete">delete</a>';
    }
}
