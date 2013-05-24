<?php
namespace Yjv\Bundle\ReportRenderingBundle\ReportData;

/**
 * interface for the data from a report that isnt editable anymore
 * @author yosefderay
 *
 */
interface ImmutableDataInterface
{
    /**
     * should return an iterable result that can be sent to a foreach
     */
    public function getData();

    /**
     * should return the count of the data to be iterated
     */
    public function getCount();

    /**
     * shoiuld return the mount of results without filters
     */
    public function getUnfilteredCount();
}
