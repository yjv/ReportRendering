<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core;

use Symfony\Component\Form\FormFactoryInterface;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\ReportRendering\Factory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    protected $widgetRenderer;
    protected $formFactory;
    
    public function __construct(WidgetRenderer $widgetRenderer = null, FormFactoryInterface $formFactory = null)
    {
        $this->widgetRenderer = $widgetRenderer;
        $this->formFactory = $formFactory;
    }
    
    public function loadTypes()
    {
        $types = array(
            new RendererType(),
            new GriddedType(),
        );
        
        if ($this->widgetRenderer) {
            
            $types[] = new HtmlType($this->widgetRenderer, $this->formFactory);
        }
        
        return $types;
    }
}
