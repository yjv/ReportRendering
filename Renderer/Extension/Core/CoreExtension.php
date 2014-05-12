<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core;


use Symfony\Component\Templating\EngineInterface;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\CsvType;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;
use Yjv\TypeFactory\AbstractExtension;

class CoreExtension extends AbstractExtension
{
    protected $renderer;

    public function __construct(EngineInterface $renderer = null)
    {
        $this->renderer = $renderer;
    }
    
    public function loadTypes()
    {
        $types = array(
            new RendererType(),
            new GriddedType(),
            new CsvType(),
        );
        
        if ($this->renderer) {
            
            $types[] = new HtmlType($this->renderer);
        }
        
        return $types;
    }
}
