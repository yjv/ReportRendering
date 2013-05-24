<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

interface ReportFactoryInterface extends TypeFactoryInterface
{
	public function getRendererFactory();
}
