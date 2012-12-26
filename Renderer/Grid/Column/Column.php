<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;
use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

class Column implements ColumnInterface {
	
	protected $dataTransformers = array();
	protected $attributes = array('sortable' => false);
	protected $rowAttributes = array();
	protected $cellAttributes = array();
	protected $data;
	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::setData()
	 */
	public function setData($data){
		
		$this->data = $data;
		return $this;
	}
	
	/**
	 * sets the array of data transformers for processing data
	 * @param array $dataTransformers
	 */
	public function setDataTransformers(array $dataTransformers) {
		
		$this->dataTransformers = $dataTransformers;
		return $this;
	}
	
	/**
	 * appends a datatransformer to the array
	 * @param DataTransofrmerInterface|callable $dataTransformer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function appendDataTransformer($dataTransformer) {
		
		$this->dataTransformers[] = $dataTransformer;
		return $this;
	}
	
	/**
	 * prepends a datatransformer to the array
	 * @param DataTransofrmerInterface|callable $dataTransformer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function prependDataTransformer($dataTransformer) {
		
		array_unshift($this->dataTransformers, $dataTransformer);
		return $this;
	}
	
	/**
	 * sets the columns attributes
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $attributes
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setAttributes(array $attributes) {
		
		$this->attributes = $attributes;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getAttributes()
	 */
	public function getAttributes() {
		
		return $this->processAttributes($this->attributes);
	}
	
	/**
	 * sets the row attributes
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $rowAttributes
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setRowAttributes(array $rowAttributes) {
		
		$this->rowAttributes = $rowAttributes;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getRowAttributes()
	 */
	public function getRowAttributes(array $previousAttributes = array()) {

		return array_merge($previousAttributes, $this->processAttributes($this->rowAttributes));
	}
	
	/**
	 * sets the columns attributes
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $cellAttributes
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setCellAttributes(array $cellAttributes) {
		
		$this->cellAttributes = $cellAttributes;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getCellAttributes()
	 */
	public function getCellAttributes() {

		return $this->processAttributes($this->cellAttributes);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getCellData()
	 */
	public function getCellData() {

		$newData = $this->data;
		
		foreach ($this->dataTransformers as $transformer) {
				
			if ($transformer instanceof DataTransformerInterface){
		
				$newData = $transformer->transform($newData, $this->data);
			}elseif (is_callable($transformer)){
				if(!call_user_func($transformer, $newData, $this->data)) {
					break;
				}
				continue;
			}else{
		
				throw new \InvalidArgumentException("The column's transformers must follow the Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface or callable");
			}
		}
		
		return $newData;
	}

	/**
	 * processes the passed attributes based on the data set for the column
	 * @param array $attributes
	 * @throws \InvalidArgumentException
	 */
	protected function processAttributes(array $attributes) {
	
		foreach ($attributes as $name => $value) {
				
			if (is_callable($value)) {
	
				$attributes[$name] = call_user_func($value, $this->data, $attributes);
			}elseif (is_object($value) && !method_exists($value, '__toString')){
	
				throw new \InvalidArgumentException('the value of an attribute must be either castable to a string or callable');
			}
		}
	
		return $attributes;
	}
}
