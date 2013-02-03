<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

interface ColumnBuilderInterface {

	/**
	 * @return array an array of options for the column
	 */
	public function getOptions();
	
	/**
	 * sets the column's options
	 * @param array $options
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setOptions(array $options);
	
	/**
	 * 
	 * @param string $name
	 * @param stinrg|callable $value
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setOption($name, $value);
	
	/**
	 * sets the columns row options
	 * @param array $options
	 */
	public function setRowOptions(array $options);
	
	/**
	 * 
	 * @param string $name
	 * @param string|callable $value
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setRowOption($name, $value);
	
	/**
	 * should return the options for the row
	 * @return array the options for the row
	 */
	public function getRowOptions();
	
	/**
	 * sets a columns cell options
	 * @param array $options
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setCellOptions(array $options);
	
	/**
	 * 
	 * @param string $name
	 * @param string|callable $value
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setCellOption($name, $value);
	
	/**
	 * @return array the options for the cell
	 */
	public function getCellOptions();
	
	/**
	 * sets the array of data transformers for processing data
	 * @param array $dataTransformers
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function setDataTransformers(array $dataTransformers);
	
	/**
	 * gets the array of data transformers set so far
	 */
	public function getDataTransformers();
	
	/**
	 * appends a datatransformer to the array
	 * @param DataTransofrmerInterface|callable $dataTransformer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function appendDataTransformer($dataTransformer);
	
	/**
	 * prepends a datatransformer to the array
	 * @param DataTransofrmerInterface|callable $dataTransformer
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface
	 */
	public function prependDataTransformer($dataTransformer);
	
	/**
	 * should return the same factory the builder originated from
	 */
	public function getColumnFactory();
	
	/**
	 * returns the data transformer registry
	 */
	public function getDataTransformerRegistry();
	
	/**
	 * returns the built column
	 * @return \Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface
	 */
	public function getColumn();
}
