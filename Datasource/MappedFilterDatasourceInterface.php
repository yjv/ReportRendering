<?php
namespace Yjv\ReportRendering\Datasource;



interface MappedFilterDatasourceInterface extends DatasourceInterface
{
    /**
     * sets the mapping array to use for the filter keys
     * @param array $sortMap
     */
    public function setFilterMap(array $sortMap);
}
