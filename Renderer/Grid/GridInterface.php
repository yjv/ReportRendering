<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid;
use Yjv\Bundle\ReportRenderingBundle\Renderer\RendererInterface;

interface GridInterface extends RendererInterface{

	public function addColumn($name, array $options);
}
