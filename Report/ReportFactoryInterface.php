<?php
namespace Yjv\ReportRendering\Report;

use Yjv\TypeFactory\NamedTypeFactoryInterface;

interface ReportFactoryInterface extends NamedTypeFactoryInterface
{
	public function getRendererFactory();
	public function getDatasourceFactory();
}
