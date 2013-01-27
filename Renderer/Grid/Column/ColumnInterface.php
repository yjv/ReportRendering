<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

interface ColumnInterface {

	/**
	 * @return array an array of options for the column
	 */
	public function getOptions();
	
	/**
	 * 
	 * @param array $previousOptions
	 * @return array the options for the row given the data the column has at that point, probably merged with the previous columns options
	 */
	public function getRowOptions(array $previousOptions = array());
	
	/**
	 * @return array the atributes for the cell given the data the column has at that point
	 */
	public function getCellOptions();
	
	/**
	 * @return array the data for the given cell given the data it has right now
	 */
	public function getCellData();
	
	/**
	 * set the current row data
	 * @param mixed $data
	 * @return mixed should be something castable to a string
	 */
	public function setData($data);
	
	/**
	 * sets the column's options
	 * @param array $options
	 */
	public function setOptions(array $options);
	
	/**
	 * 
	 * @param string $name
	 * @param stinrg|callable $value
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
	 */
	public function setRowOption($name, $value);
	
	/**
	 * sets a columns cell options
	 * @param array $options
	 */
	public function setCellOptions(array $options);
	
	/**
	 * 
	 * @param string $name
	 * @param string|callable $value
	 */
	public function setCellOption($name, $value);
}
