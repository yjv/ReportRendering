<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;
use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

class Column implements ColumnInterface {
	
	protected $dataTransformers = array();
	protected $options = array();
	protected $rowOptions = array();
	protected $cellOptions = array();
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
	
	public function getDataTransformers() {
		
		return $this->dataTransformers;
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
	 * sets the columns options
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $options
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setOptions(array $options) {
		
		$this->options = $options;
		return $this;
	}
	
	/**
	 * @param unknown $name
	 * @param unknown $value
	 */
	public function setOption($name, $value) {

		$this->options[$name] = $value;
		return $this;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getOptions()
	 */
	public function getOptions() {
		
		return $this->processOptions($this->options);
	}
	
	/**
	 * sets the row options
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $rowOptions
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setRowOptions(array $rowOptions) {
		
		$this->rowOptions = $rowOptions;
		return $this;
	}
	
	/**
	 * @param unknown $name
	 * @param unknown $value
	 */
	public function setRowOption($name, $value) {

		$this->rowOptions[$name] = $value;
		return $this;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getRowOptions()
	 */
	public function getRowOptions(array $previousOptions = array()) {

		return array_merge($previousOptions, $this->processOptions($this->rowOptions));
	}
	
	/**
	 * sets the columns options
	 * combination of key value pairs values being either castable to a string or callable
	 * @param array $cellOptions
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\Column
	 */
	public function setCellOptions(array $cellOptions) {
		
		$this->cellOptions = $cellOptions;
		return $this;
	}
	
	/**
	 * @param unknown $name
	 * @param unknown $value
	 */
	public function setCellOption($name, $value) {

		$this->cellOptions[$name] = $value;
		return $this;
	}

	
	/**
	 * (non-PHPdoc)
	 * @see Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column.ColumnInterface::getCellOptions()
	 */
	public function getCellOptions() {

		return $this->processOptions($this->cellOptions);
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
	 * processes the passed options based on the data set for the column
	 * @param array $options
	 * @throws \InvalidArgumentException
	 */
	protected function processOptions(array $options) {
	
		foreach ($options as $name => $value) {
				
			if (is_callable($value)) {
	
				$options[$name] = call_user_func($value, $this->data, $options);
			}elseif (is_object($value) && !method_exists($value, '__toString')){
	
				throw new \InvalidArgumentException('the value of an option must be either castable to a string or callable');
			}
		}
	
		return $options;
	}
}
