<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

interface ColumnInterface {

	/**
	 * @return array an array of attributes for the column
	 */
	public function getAttributes();
	
	/**
	 * 
	 * @param array $previousAttributes
	 * @return array the attributes for the row given the data the column has at that point, probably merged with the previous columns attributes
	 */
	public function getRowAttributes(array $previousAttributes = array());
	
	/**
	 * @return array the atributes for the cell given the data the column has at that point
	 */
	public function getCellAttributes();
	
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
}
