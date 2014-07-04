<?php
namespace GtnDataTables\View\Helper;

use GtnDataTables\Model\Column;
use GtnDataTables\View\Helper;
use GtnDataTables\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\View\Helper\AbstractHelper;

class DataTable extends AbstractHelper implements ServiceManagerAwareInterface
{
    /** @var ServiceManager */
    protected $serviceManager;

    /** @var Service\DataTable */
    protected $datatable;

    /**
     * @param $key
     * @return Helper\DataTable
     */
    public function __invoke($key)
    {
        $this->datatable = $this->serviceManager->get($key);
        return $this;
    }

    /**
     * @return string
     */
    public function renderHtml()
    {
        $classes_list = implode(' ', $this->datatable->getClasses());
        $id = $this->datatable->getId();
        $result = <<<EOD
<table class="$classes_list" id="$id">
    <thead>
        <tr>

EOD;
        /** @var Column $column */
        foreach ($this->datatable->getColumns() as $column) {
            $result .= '            <th>' . $column->getTitle() . '</th>' . PHP_EOL;
        }
        $result .= <<<EOD
        </tr>
    </thead>
</table>
EOD;
        return $result;
    }

    /**
     * Set service manager
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
}
