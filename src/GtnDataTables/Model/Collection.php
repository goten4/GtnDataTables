<?php
namespace GtnDataTables\Model;

class Collection implements \Iterator, \Countable
{
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var int
     */
    protected $total;

    /**
     * @var int
     */
    protected $filteredCount;

    /**
     * @param array $data
     * @param int   $total
     * @param int   $filteredCount
     * @return Collection
     */
    public static function factory(array $data, $total = null, $filteredCount = null)
    {
        $collection = new Collection();
        $collection->setData($data);
        $collection->setTotal($total);
        $collection->setFilteredCount($filteredCount);
        return $collection;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid()
    {
        return isset($this->data[$this->index]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *       </p>
     *       <p>
     *       The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Get Data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data.
     *
     * @param array $data
     * @return Collection
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get Total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set Total.
     *
     * @param int $total
     * @return Collection
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Get FilteredCount.
     *
     * @return int
     */
    public function getFilteredCount()
    {
        return $this->filteredCount;
    }

    /**
     * Set FilteredCount.
     *
     * @param int $filteredCount
     * @return Collection
     */
    public function setFilteredCount($filteredCount)
    {
        $this->filteredCount = $filteredCount;
        return $this;
    }

    /**
     * @param $index
     * @return Object
     */
    public function get($index)
    {
        return $this->data[$index];
    }
}
