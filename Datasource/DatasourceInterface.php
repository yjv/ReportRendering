<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;

/**
 * @author yosefderay
 *
 */
interface DatasourceInterface
{
    /**
     * returns the report data must a ReportDataInterface interface object (must be editable)
     *
     */
    public function getData(array $filterValues);
}
