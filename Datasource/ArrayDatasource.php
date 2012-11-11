<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

class ArrayDatasource implements DatasourceInterface {

	protected $data;
	protected $processedData;
	protected $filters;
	
	public function __construct($data){
		
		if ($data instanceof \Traversable) {
			
			$data = iterator_to_array($data);
		}
		
		if (!is_array($data)) {
			
			throw new \InvalidArgumentException('$data must be either an array or an instance of Traversable');
		}
		
		$this->data = $data;
	}
	
	public function getReportData($forceReload = false) {

	}
	
	public function setFilters(FilterCollectionInterface $filters) {

	}

	protected function processData() {
		
		;
	}
}
