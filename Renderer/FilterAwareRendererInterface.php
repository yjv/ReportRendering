<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Filter\FilterCollectionInterface;

interface FilterAwareRendererInterface extends RendererInterface{

	/**
	 * sets the filter collectionfrom the report
	 * @param FilterCollectionInterface $filters
	 */
	public function setFilters(FilterCollectionInterface $filters);
}
