<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter;

/**
 * class meant to just follow the filter collection interface but not do anything
 * @author yosefderay
 *
 */
class NullFilterCollection implements FilterCollectionInterface
{
    /**
     * (non-PHPdoc)
     * @see \Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface::set()
     */
    public function set($name, $value)
    {
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface::setAll()
     */
    public function setAll(array $values)
    {
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface::get()
     */
    public function get($name, $default = null)
    {
        return $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface::all()
     */
    public function all()
    {
        return array();
    }
}
