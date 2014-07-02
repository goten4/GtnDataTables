<?php
namespace GtnDataTablesTest\Model;

class Server
{
    protected $name;

    public function __construct($name = null)
    {
        $this->setName($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
