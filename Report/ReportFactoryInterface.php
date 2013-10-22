<?php
namespace Yjv\ReportRendering\Report;

use Yjv\TypeFactory\TypeFactoryInterface;

interface ReportFactoryInterface extends TypeFactoryInterface
{
	public function getRendererFactory();
	public function getDatasourceFactory();
}
