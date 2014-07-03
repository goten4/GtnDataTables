<?php
namespace GtnDataTables\Service;

use GtnDataTables\Model;

class DataTable
{
    /**
     * @var CollectorInterface
     */
    protected $collector;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @param CollectorInterface $collector
     * @param array              $columns
     */
    public function __construct(CollectorInterface $collector = null, array $columns = null)
    {
        $this->setCollector($collector);
        $this->setColumns($columns);
    }

    /**
     * @param $params
     * @return Model\Result
     */
    public function getResult($params)
    {
        $datatable = new Model\Result();

        $order = array();
        if (isset($params['order'])) {
            foreach ($params['order'] as $clause) {
                $order[] = array(
                    'column' => $this->getColumn($clause['column'])->getKey(),
                    'dir' => $clause['dir'],
                );
            }
        }
        $collection = $this->getCollector()->findAll($params['start'], $params['length'], $params['search']['value'], $order);
        $data = array();
        foreach ($collection as $object) {
            $row = array();
            foreach ($this->getColumns() as $column) {
                /** @var Model\Column $column */
                $row[] = $column->getDecorator()->decorateValue($object);
            }
            $data[] = $row;
        }
        $datatable->setData($data);
        $datatable->setDraw(intval($params['draw']));
        $datatable->setRecordsFiltered($collection->getFilteredCount());
        $datatable->setRecordsTotal($collection->getTotal());

        return $datatable;
    }

    /**
     * Get Collector.
     *
     * @return \GtnDataTables\Service\CollectorInterface
     */
    public function getCollector()
    {
        return $this->collector;
    }

    /**
     * Set Collector.
     *
     * @param \GtnDataTables\Service\CollectorInterface $collector
     * @return DataTable
     */
    public function setCollector($collector)
    {
        $this->collector = $collector;
        return $this;
    }

    /**
     * @param $index
     * @return Model\Column
     */
    public function getColumn($index)
    {
        return $this->columns[$index];
    }

    /**
     * Get Columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set Columns.
     *
     * @param array $columns
     * @return DataTable
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }
}
