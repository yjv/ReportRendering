<?php
namespace Yjv\ReportRendering\Datasource;



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
