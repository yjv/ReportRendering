<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;
use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableReportData;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

class CallbackDatasource implements DatasourceInterface {

	protected $callback;
	protected $params;
	protected $filters;
	protected $data;

	public function __construct($callback, array $params = array()) {
		
		if (!is_callable($callback)) {
			
			throw new \InvalidArgumentException('$callback must be callable');
		}
		
		$this->callback = $callback;
		$this->params = $params;
	}
	
	public function getReportData($forceReload = false) {

		if (!empty($this->data) && !$forceReload) {
			
			return $this->data;
		}
		
		$params = array_merge($this->params, $this->filters->getValues());
		
		$reflectionFunction = new \ReflectionFunction($this->callback);
		
		$args = array();
		
		foreach ($reflectionFunction->getParameters() as $parameter) {
			
			if (array_key_exists($parameter->getName(), $params)) {
				
				$args[] = $params[$parameter->getName()];
			}else{
				
				$args[] = null;
			}
		}
		
		return $this->data = $reflectionFunction->invoke($args);
	}
	
	public function setFilters(FilterCollectionInterface $filters) {

		$this->filters = $filters;
		return $this;
	}

}
