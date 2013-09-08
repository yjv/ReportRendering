<?php
namespace Yjv\ReportRendering\Renderer\Grid;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

interface GridInterface extends \Traversable
{
	public function addColumn(ColumnInterface $column);
	public function getColumns();
	public function getRows();
	public function setData(ImmutableDataInterface $data);
	public function setForceReload($forceReload);
}
