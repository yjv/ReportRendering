<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Datasource\DatasourceInterface;

interface MappedSortDatasource extends DatasourceInterface{

	/**
	 * sets the mapping array to use for the sort filter value
	 * @param array $sortMap
	 */
	public function setSortMap(array $sortMap);
}
