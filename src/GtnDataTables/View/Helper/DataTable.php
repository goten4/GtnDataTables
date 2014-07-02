<?php
namespace GtnDataTables\View\Helper;

use GtnDataTables\Model\Column;
use Zend\View\Helper\AbstractHelper;

class DataTable extends AbstractHelper
{
    public function __invoke(array $columns, $id, $classes = array())
    {
        $classes_list = implode(' ', $classes);
        $result = <<<EOD
<table class="$classes_list" id="$id">
    <thead>
        <tr>

EOD;
        /** @var Column $column */
        foreach ($columns as $column) {
            $result .= '            <th>' . $column->getTitle() . '</th>' . PHP_EOL;
        }
        $result .= <<<EOD
        </tr>
    </thead>
</table>
EOD;
        return $result;
    }
}
