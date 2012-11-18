<?php
namespace Yjv\Bundle\ReportRenderingBundle\Datasource;

use Yjv\Bundle\ReportRenderingBundle\Filter\NullFilterCollection;

use Symfony\Component\Form\Util\PropertyPath;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

class ArrayDatasource implements MappedSortDatasource {

	protected $data;
	protected $processedData;
	protected $filters;
	protected $sortMap = array();
	protected $filterMap = array();
	
	public function __construct($data){
		
		if ($data instanceof \Traversable) {
			
			$data = iterator_to_array($data);
		}
		
		if (!is_array($data)) {
			
			throw new \InvalidArgumentException('$data must be either an array or an instance of Traversable');
		}
		
		$this->data = $data;
		$this->filters = new NullFilterCollection();
	}
	
	public function getData($forceReload = false) {

		if ($forceReload || empty($this->processedData)) {
			
			$this->processData();
		}
		
		return $this->processedData;
	}
	
	public function setFilters(FilterCollectionInterface $filters) {

		$this->filters = $filters;
		return $this;
	}
	
	public function setSortMap(array $sortMap){
		
		$this->sortMap = $sortMap;
		return $this;
	}
	
	public function setFilterMap(array $filterMap){
		
		$this->filterMap = $filterMap;
		return $this;
	}

	protected function processData() {
		
		$this->processedData = $this->data;
		
		if ($this->filters->get('sort', false)) {
			
			$sort = $this->filters->get('sort');
			reset($sort);
			$order = current($sort);
			$sort = $this->mapSort(key($sort));
			
			$propertyPath = new PropertyPath((string)$sort);
			
			uasort($this->processedData, function($a, $b) use ($propertyPath, $order){
				
				$valueA = $propertyPath->getValue($a);
				$valueB = $propertyPath->getValue($b);
				return ($order == 'asc' ? 1 : -1) * strcasecmp($valueA, $valueB);
			});
		}
		
		$filters = $this->filters->all();
		unset($filters['sort']);
		
		foreach ($filters as $name => $value) {
			
			$propertyPath = new PropertyPath($this->mapFilter($name));
			
			$this->processedData = array_filter($this->processedData, function($data) use ($value, $propertyPath){
				
				$data = $propertyPath->getValue($data);
				if (stripos($data, $value) === 0) {
					
					return true;
				}
				return false;
			});
		}
	}
	
	protected function mapSort($sort) {
		
		return isset($this->sortMap[$sort]) ? $this->sortMap[$sort] : $sort;
	}
	
	protected function mapFilter($filter) {
		
		return isset($this->filterMap[$filter]) ? $this->filterMap[$filter] : $filter;
	}
}
