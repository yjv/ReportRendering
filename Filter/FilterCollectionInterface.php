<?php
namespace Yjv\ReportRendering\Filter;

/**
 * interface for any object to follow if it wants to hold report filters
 * @author yosefderay
 *
 */
interface FilterCollectionInterface
{
    /**
     * 
     * @param string $name
     * @param mixed $value
     * @return $this
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
     * @param string $name
     * @param mixed $default
     * @throws \Yjv\ReportRendering\Filter\ReportNameNotSetException
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * an exception should be thrown if the collection requires the report to be set before filter
     * loading
     * @throws \Yjv\ReportRendering\Filter\ReportNameNotSetException
     * @return array
     */
    public function all();

    /**
     * @param array $values
     * @return $this
     */
    public function replace(array $values);

    /**
     * @param $name
     * @return $this
     */
    public function remove($name);

    public function clear();
}
