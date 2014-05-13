<?php
namespace Yjv\ReportRendering\Filter;

/**
 * interface to be followed for filter collections that want the ability for defaults to be set
 * 
 * @author yosefderay
 *
 */
interface DefaultedFilterCollectionInterface extends FilterCollectionInterface
{
    /**
     * this method should override these defaults with whats already set
     * @param array $defaults
     */
    public function setDefaults(array $defaults);

    /**
     * this method should override the defaults with whats already set
     * @param string|mixed $name
     * @param mixed $value
     */
    public function setDefault($name, $value);
}
