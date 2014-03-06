<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Builder;

use Yjv\ReportRendering\Renderer\Csv\CsvRenderer;

use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;

class CsvBuilder extends AbstractRendererBuilder
{
    public function getRenderer()
    {
        return new CsvRenderer($this->getGrid());
    }
}
