<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

class ColumnBuilder implements ColumnBuilderInterface{

	protected $options = array();
	protected $rowOptions = array();
	protected $cellOptions = array();
	protected $dataTransformers = array();
	protected $columnFactory;
	
	public function __construct(ColumnFactory $columnFactory) {
		
		$this->columnFactory = $columnFactory;
	}
	
	/**
     * {@inheritdoc}
     */
	public function getOptions(){
		
		return $this->options;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setOptions(array $options){
		
		$this->options = $options;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setOption($name, $value){
		
		$this->options[$name] = $value;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setRowOptions(array $options){
		
		$this->rowOptions = $options;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setRowOption($name, $value){
		
		$this->rowOptions[$name] = $value;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function getRowOptions(){
		
		return $this->rowOptions;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setCellOptions(array $options){
		
		$this->cellOptions = $options;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setCellOption($name, $value){
				
		$this->cellOptions[$name] = $value;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function getCellOptions(){
		
		return $this->cellOptions;
	}
	
    /**
     * {@inheritdoc}
     */
	public function setDataTransformers(array $dataTransformers){
		
		$this->dataTransformers = $dataTransformers;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function getDataTransformers(){
		
		return $this->dataTransformers;
	}
	
    /**
     * {@inheritdoc}
     */
	public function appendDataTransformer($dataTransformer){
		
		$this->dataTransformers[] = $dataTransformer;
		return $this;
	}
	
    /**
     * {@inheritdoc}
     */
	public function prependDataTransformer($dataTransformer) {
		
		array_unshift($this->dataTransformers, $dataTransformer);
		return $this;
	}
	
	/**
     * {@inheritdoc}
	 */
	public function getColumnFactory() {

		return $this->columnFactory;
	}

	/**
	 * 
	 */
	public function getDataTransformerRegistry() {

		return $this->columnFactory->getDataTransformerRegistry();
	}

	/**
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface
	 */
	public function getColumn() {

		$column = new Column();
		$column
			->setOptions($this->options)
			->setRowOptions($this->rowOptions)
			->setCellOptions($this->cellOptions)
			->setDataTransformers($this->dataTransformers)
		;
		
		return $column;
	}

}
