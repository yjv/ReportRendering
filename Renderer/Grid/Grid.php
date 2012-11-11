<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid;
use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Row\Row;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

class Grid implements GridInterface {
	
	protected $data;
	protected $columns = array();
	protected $columnOptionsResolver;
	protected $rows = array();
	protected $reportId;
	
	public function __construct() {
		
		$this->columnOptionsResolver = new OptionsResolver();
		$this->columnOptionsResolver
			->setOptional(array('transformers', 'sortable', 'row_attributes', 'cell_attributes'))
			->setDefaults(array(
					'transformers' => array(),
					'sortable' => false,
					'row_attributes' => array(),
					'cell_attributes' => array(),
			))
			->setAllowedTypes(array(
					'transformers' => 'array',
					'sortable' => 'bool',		
					'row_attributes' => 'array',
					'row_attributes' => 'array',
			))
		;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface::setData()
	 */
	public function setData(ImmutableDataInterface $data) {

		$this->data = $data;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface::getForceReload()
	 */
	public function getForceReload() {

		return true;
	}
	
	/**
	 * @param array $options
	 */
	public function getRows() {

		$this->loadRows();
		return $this->rows;
	}

	/**
	 * @param array $options
	 */
	public function render(array $options = array()) {

		return $this->getRows();
	}

	public function addColumn($name, array $options) {
		
		$this->columns[$name] = $this->columnOptionsResolver->resolve($options);
		return $this;
	}
	
	public function getColumns() {
		
		return $this->columns;
	}
	
	public function setReportId($reportId){
		
		$this->reportId = $reportId;
		return $this;
	}
	
	protected function loadRows() {
		
		if (!empty($this->rows)) {
			
			return;
		}
		
		foreach ($this->data->getData() as $rowData) {
			
			$row = array('cells' => array(), 'attributes' => array());
			
			$rowAttributes = array();
			
			foreach ($this->columns as $column) {
				
				$row['cells'][] = array(
					'options' => $column,
					'attributes' => $this->processAttributes($column['cell_attributes'], $rowData),
					'data' => $this->processColumn($rowData, $column['transformers'])
				);
				
				$row['attributes'] = array_merge($row['attributes'], $this->processAttributes($row['attributes'], $column['row_attributes']));
			}
			
			$this->rows[] = $row;
		}
	}
	
	protected function processColumn($data, array $transformers) {
		
		$newData = $data;
		
		foreach ($transformers as $transformer) {
			
			if ($transformer instanceof DataTransformerInterface){
				
				$newData = $transformer->transform($newData, $data);
			}elseif ($transformer instanceof \Closure && !$transformer($newData, $data)) {
				
				break;
			}else{
				
				throw new \InvalidArgumentException("The column's transformers must follow the Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface or be a \Closure instance");
			}
		}
		
		return $newData;
	}
	
	protected function processAttributes(array $attributes, $data) {
		
		foreach ($attributes as $name => $value) {
			
			if ($value instanceof \Closure) {
				
				$attributes[$name] = $value($data, $attributes);
			}elseif (is_object($value) && !method_exists($value, '__toString')){
				
				throw new \InvalidArgumentException('the value of an attribute must be either castable to a string or an instance of \Callable');
			}
		}
		
		return $attributes;
	}
}
