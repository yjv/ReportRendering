<?php
namespace Yjv\ReportRendering\Filter;

use Yjv\ReportRendering\Report\ReportInterface;

/**
 * interface for filtercollections that want to store filters for more that one report to follow
 * @author yosefderay
 *
 */
interface MultiReportFilterCollectionInterface extends FilterCollectionInterface
{
    /**
     * the identifier for the report so that the filter collection
     * knows which report its loading filters for
     * the collection should throw an exception if the report
     * is not set before attempting to load the filter values
     * @param $reportName
     * @return $this
     */
    public function setReportName($reportName);
}
