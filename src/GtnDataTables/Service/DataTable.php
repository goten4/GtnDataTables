<?php
namespace GtnDataTables\Service;

use GtnDataTables\Model;

class DataTable
{
    /** @var string */
    protected $id;

    /** @var array */
    protected $classes;

    /** @var CollectorInterface */
    protected $collector;

    /** @var array */
    protected $columns;

    /**
     * @param string             $id
     * @param CollectorInterface $collector
     * @param array              $columns
     * @param array              $classes
     */
    public function __construct($id = null, CollectorInterface $collector = null, array $columns = null, array $classes = null)
    {
        $this->setId($id);
        $this->setCollector($collector);
        $this->setColumns($columns);
        $this->setClasses($classes);
    }

    /**
     * @param $params
     * @param $context
     * @return Model\Result
     */
    public function getResult($params, $context = null)
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
        $params['order'] = $order;

        if (isset($params['columns'])) {
            foreach ($params['columns'] as $index => $column) {
                $params['columns'][$index]['column'] = $this->getColumn($index)->getKey();
            }
        }

        $collection = $this->getCollector()->findAll($params);

        $data = array();
        foreach ($collection as $object) {
            $row = array();
            foreach ($this->getColumns() as $column) {
                /** @var Model\Column $column */
                $row[] = $column->getDecorator()->decorateValue($object, $context);
            }
            $data[] = $row;
        }
        $datatable->setData($data);
        $datatable->setDraw(isset($params['draw']) ? intval($params['draw']) : null);
        $datatable->setRecordsFiltered($collection->getFilteredCount());
        $datatable->setRecordsTotal($collection->getTotal());

        return $datatable;
    }

    /**
     * Get Id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id.
     *
     * @param string $id
     * @return DataTable
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    /**
     * Get Classes.
     *
     * @return array
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set Classes.
     *
     * @param array $classes
     * @return DataTable
     */
    public function setClasses($classes)
    {
        $this->classes = $classes;
        return $this;
    }
}
