<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

interface ColumnInterface {

	public function getAttributes();
	public function getRowAttributes($previousAttributes = array());
	public function getCellAttributes();
	public function getCellData();
	public function setData($data);
}
