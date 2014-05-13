<?php
namespace Yjv\ReportRendering\Filter;

/**
 * holds fileter values optionaly set as an array on construction
 * @author yosefderay
 *
 */
class ArrayFilterCollection implements DefaultedFilterCollectionInterface
{
    protected $filters = array();

    public function __construct(array $initialFilters = array())
    {
        $this->filters = $initialFilters;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::set()
     */
    public function set($name, $value)
    {
        $this->filters[$name] = $value;
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::setAll()
     */
    public function setAll(array $values)
    {
        $this->filters = array_replace($this->filters, $values);
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::get()
     */
    public function get($name, $default = null)
    {
        return isset($this->filters[$name]) ? $this->filters[$name] : $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::all()
     */
    public function all()
    {
        return $this->filters;
    }

    /**
     * 
     * @param array $defaults
     * @return \Yjv\ReportRendering\Filter\ArrayFilterCollection
     */
    public function setDefaults(array $defaults)
    {
        $this->filters = array_replace($defaults, $this->filters);
        return $this;
    }

    /**
     * 
     * @param scalar $name
     * @param mixed $value
     * @return \Yjv\ReportRendering\Filter\ArrayFilterCollection
     */
    public function setDefault($name, $value)
    {
        if (!array_key_exists($name, $this->filters)) {

            $this->filters[$name] = $value;
        }

        return $this;
    }

    public function replace(array $values)
    {
        $this->filters = $values;
        return $this;
    }

    public function remove($name)
    {
        unset($this->filters[$name]);
        return $this;
    }

    public function clear()
    {
        $this->filters = array();
        return $this;
    }
}
