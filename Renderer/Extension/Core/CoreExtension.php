<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Factory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    protected $widgetRenderer;
    
    public function __construct(WidgetRenderer $widgetRenderer = null)
    {
        $this->widgetRenderer = $widgetRenderer;
    }
    
    public function loadTypes()
    {
        $types = array(
            new RendererType(),
            new GriddedType(),
        );
        
        if ($this->widgetRenderer) {
            
            $types[] = new HtmlType($this->widgetRenderer);
        }
        
        return $types;
    }
}
