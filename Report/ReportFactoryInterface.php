<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

interface ReportFactoryInterface extends TypeFactoryInterface
{
	public function getRendererFactory();
	public function getDatasourceFactory();
}
