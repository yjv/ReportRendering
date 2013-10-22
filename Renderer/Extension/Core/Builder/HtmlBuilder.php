<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Builder;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\ReportRendering\Widget\WidgetRendererInterface;

use Yjv\ReportRendering\Renderer\Html\HtmlRenderer;

use Yjv\ReportRendering\Renderer\Csv\CsvRenderer;

use Yjv\ReportRendering\Renderer\AbstractRendererBuilder;

class HtmlBuilder extends AbstractRendererBuilder
{
    protected $widgetRenderer;
    protected $template;
    
    public function __construct(
        WidgetRendererInterface $widgetRenderer, 
        TypeFactoryInterface $factory, 
        array $options = array()
    ) {
        $this->widgetRenderer = $widgetRenderer;
        parent::__construct($factory, $options);
    }
    
    public function getWidgetRenderer()
    {
        return $this->widgetRenderer;
    }
    
    public function setWidgetRenderer(WidgetRendererInterface $widgetRenderer)
    {
        $this->widgetRenderer = $widgetRenderer;
        return $this;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }
    
    public function getRenderer()
    {
        $renderer =  new HtmlRenderer(
            $this->widgetRenderer, 
            $this->grid, 
            $builder->getOption('template')
        );
        
        foreach ($builder->getOption('widget_attributes') as $name => $value) {
            
            $renderer->setAttribute($name, $value);
        }
        
        if ($builder->getOption('filter_form')) {
            
            $renderer->setFilterForm($builder->getOption('filter_form'));
        }
        
        foreach ($builder->getOption('options') as $name => $value) {
            
            $renderer->setOption($name, $value);
        }
        
        return $renderer;
    }
}
