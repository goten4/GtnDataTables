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
     * @param $context
     * @return string
     */
    public function decorateValue($object, $context = null)
    {
        return '<a href="/servers/' . $object->getName() . '/delete">delete</a>';
    }
}
