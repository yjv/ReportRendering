<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

/**
 * @author yosefderay
 *
 */
interface DatasourceInterface {

	/**
	 * returns the report data must a ReportDataInterface interface object (must be editable)
	 */
	public function getData($forceReload = false);
	
	/**
	 * 
	 * @param FilterCollectionInterface $filters
	 */
	public function setFilters(FilterCollectionInterface $filters);
}