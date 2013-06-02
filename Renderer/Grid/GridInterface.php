<?php
namespace Yjv\ReportRendering\Renderer\Grid;
use Yjv\ReportRendering\ReportData\ImmutableDataInterface;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnInterface;

use Yjv\ReportRendering\Renderer\RendererInterface;

interface GridInterface{

	public function addColumn(ColumnInterface $column);
	public function getColumns();
	public function getRows($forceReload = false);
	public function setData(ImmutableDataInterface $data);
}
