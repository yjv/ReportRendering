<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

interface FilterAwareRendererInterface extends RendererInterface{

	public function setFilters(FilterCollectionInterface $filters);
}
