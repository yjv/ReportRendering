<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

use Yjv\Bundle\ReportRenderingBundle\Datasource\Input\InputInterface;

/**
 * @author yosefderay
 *
 */
interface DatasourceInterface {

	/**
	 * returns the report data must a ReportDataInterface interface object (must be editable)
	 */
	public function getReportData($forceReload = false);
	
	/**
	 * 
	 * @param FilterCollectionInterface $filters
	 */
	public function setFilters(FilterCollectionInterface $filters);
}
