<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Row\Row;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

class Grid implements GridInterface {
	
	protected $data;
	protected $columns = array();
	protected $rows = array();
		
	/**
	 * (non-PHPdoc)
	 * @see \Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface::setData()
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
			
			$row = array('cells' => array(), 'attributes' => array());
			
			$rowAttributes = array();
			
			foreach ($this->columns as $column) {
				
				$column->setData($rowData);
				
				$row['cells'][] = array(
					'attributes' => $column->getCellAttributes(),
					'data' => $column->getCellData()
				);

				$row['attributes'] = $column->getRowAttributes($row['attributes']);
			}
			
			$this->rows[] = $row;
		}
	}
}
