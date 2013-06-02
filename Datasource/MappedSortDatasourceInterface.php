<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceInterface;

interface MappedSortDatasourceInterface extends DatasourceInterface
{
    /**
     * sets the mapping array to use for the sort filter value
     * @param array $sortMap
     */
    public function setSortMap(array $sortMap);
}
