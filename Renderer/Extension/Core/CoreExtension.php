<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core;

use Symfony\Component\Templating\EngineInterface;

use Symfony\Component\Form\FormFactoryInterface;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;

use Yjv\ReportRendering\Widget\WidgetRenderer;

use Yjv\TypeFactory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    protected $renderer;
    protected $formFactory;
    
    public function __construct(EngineInterface $renderer = null, FormFactoryInterface $formFactory = null)
    {
        $this->renderer = $renderer;
        $this->formFactory = $formFactory;
    }
    
    public function loadTypes()
    {
        $types = array(
            new RendererType(),
            new GriddedType(),
        );
        
        if ($this->renderer) {
            
            $types[] = new HtmlType($this->renderer, $this->formFactory);
        }
        
        return $types;
    }
}
