<?php
namespace GtnDataTables\View\Helper;

use GtnDataTables\Model\Column;
use GtnDataTables\View\Helper;
use GtnDataTables\Service;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager;

class DataTable extends AbstractHelper implements ServiceLocatorAwareInterface
{
    /** @var HelperPluginManager */
    protected $helperPluginManager;

    /** @var Service\DataTable */
    protected $datatable;

    /**
     * @param $key
     * @return Helper\DataTable
     */
    public function __invoke($key)
    {
        $this->datatable = $this->helperPluginManager->getServiceLocator()->get($key);
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
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->helperPluginManager;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->helperPluginManager = $serviceLocator;
    }
}
