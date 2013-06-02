<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Filter\FilterCollectionInterface;

interface FilterAwareRendererInterface extends RendererInterface
{
    /**
     * sets the filter collectionfrom the report
     * @param FilterCollectionInterface $filters
     */
    public function setFilters(FilterCollectionInterface $filters);
}
