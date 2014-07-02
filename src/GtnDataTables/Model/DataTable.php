<?php
namespace GtnDataTables\Model;

class DataTable
{
    /** @var int */
    protected $data;

    /** @var int */
    protected $draw;

    /** @var int */
    protected $recordsFiltered;

    /** @var int */
    protected $recordsTotal;

    /**
     * Get data.
     *
     * @return int
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data.
     *
     * @param int $data
     * @return DataTable
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get Draw.
     *
     * @return int
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * Set Draw.
     *
     * @param int $draw
     * @return DataTable
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;
        return $this;
    }

    /**
     * Get RecordsFiltered.
     *
     * @return int
     */
    public function getRecordsFiltered()
    {
        return $this->recordsFiltered;
    }

    /**
     * Set RecordsFiltered.
     *
     * @param int $recordsFiltered
     * @return DataTable
     */
    public function setRecordsFiltered($recordsFiltered)
    {
        $this->recordsFiltered = $recordsFiltered;
        return $this;
    }

    /**
     * Get RecordsTotal.
     *
     * @return int
     */
    public function getRecordsTotal()
    {
        return $this->recordsTotal;
    }

    /**
     * Set RecordsTotal.
     *
     * @param int $recordsTotal
     * @return DataTable
     */
    public function setRecordsTotal($recordsTotal)
    {
        $this->recordsTotal = $recordsTotal;
        return $this;
    }
}
