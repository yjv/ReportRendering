<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid;
use Yjv\Bundle\ReportRenderingBundle\ReportData\ImmutableDataInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

interface GridInterface{

	public function addColumn(ColumnInterface $column);
	public function getColumns();
	public function getRows($forceReload = false);
	public function setData(ImmutableDataInterface $data);
}
