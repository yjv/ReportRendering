<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceInterface;

interface MappedFilterDatasourceInterface extends DatasourceInterface
{
    /**
     * sets the mapping array to use for the filter keys
     * @param array $sortMap
     */
    public function setFilterMap(array $sortMap);
}
