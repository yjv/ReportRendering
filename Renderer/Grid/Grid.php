<?php
namespace Yjv\ReportRendering\Renderer\Grid;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

class Grid implements GridInterface {
	
	protected $data;
	protected $columns = array();
	protected $rows = array();
		
	/**
	 * (non-PHPdoc)
	 * @see \Yjv\ReportRendering\Renderer\RendererInterface::setData()
	 */
	public function setData(ImmutableDataInterface $data) {

		$this->data = $data;
		return $this;
	}
	
	/**
	 * @param array $options
	 */
	public function getRows($forceReload = false) {

		$this->loadRows($forceReload);
		return $this->rows;
	}

	public function addColumn(ColumnInterface $column) {
		
		$this->columns[] = $column;
		return $this;
	}
	
	public function getColumns() {
		
		return $this->columns;
	}
	
	protected function loadRows($forceReload) {
		
		if (!empty($this->rows) && !$forceReload) {
			
			return;
		}
		
		$this->rows = array();
		
		foreach ($this->data->getData() as $rowData) {
			
			$row = array('cells' => array(), 'options' => array());
			
			foreach ($this->columns as $column) {
				
				$column->setData($rowData);
				
				$row['cells'][] = array(
					'options' => $column->getCellOptions(),
					'data' => $column->getCellData()
				);

				$row['options'] = $column->getRowOptions($row['options']);
			}
			
			$this->rows[] = $row;
		}
	}
}
