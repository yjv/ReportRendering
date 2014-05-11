<?php
namespace Yjv\ReportRendering\Filter;

/**
 * class meant to just follow the filter collection interface but not do anything
 * @author yosefderay
 *
 */
class NullFilterCollection implements FilterCollectionInterface
{
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::set()
     */
    public function set($name, $value)
    {
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::setAll()
     */
    public function setAll(array $values)
    {
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::get()
     */
    public function get($name, $default = null)
    {
        return $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Filter\FilterCollectionInterface::all()
     */
    public function all()
    {
        return array();
    }

    public function replace(array $values)
    {
        return $this;
    }

    public function remove($name)
    {
        return $this;
    }
}
