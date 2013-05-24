<?php
namespace Yjv\Bundle\ReportRenderingBundle\Filter;

/**
 * interface for any object to follow if it wants to hold report filters
 * @author yosefderay
 *
 */
interface FilterCollectionInterface
{
    /**
     * 
     * @param scalar $name
     * @param mixed $value
     */
    public function set($name, $value);

    /**
     * 
     * @param array $values
     */
    public function setAll(array $values);

    /**
     * an exception should be thrown if the collection requires the report to be set before filter
     * loading
     * @param scalar $name
     * @param mixed $default
     * @throws \Yjv\Bundle\ReportRenderingBundle\Filter\ReportIdNotSetException
     */
    public function get($name, $default = null);

    /**
     * an exception should be thrown if the collection requires the report to be set before filter
     * loading
     * @throws \Yjv\Bundle\ReportRenderingBundle\Filter\ReportIdNotSetException
     * @return array|\ArrayAccess
     */
    public function all();
}
