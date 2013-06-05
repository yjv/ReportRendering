<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\Builder;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Yjv\ReportRendering\Renderer\RendererTypeDelegateInterface;
use Yjv\ReportRendering\Renderer\RendererInterface;
use Yjv\ReportRendering\Datasource\DatasourceInterface;

class RendererBuilder extends Builder implements RendererBuilderInterface
{
    protected $callback;

    public function getRenderer()
    {
        $constructor = $this->callback;
        $renderer = $constructor($this);
        
        if (!$renderer instanceof RendererInterface) {
            
            throw new ValidRendererNotReturnedException();
        }
        
        return $renderer;
    }

    public function setConstructor($callback)
    {
        if (!is_callable($callback)) {
            
            throw new \InvalidArgumentException('$callback must a valid callable.');
        }
        
        $this->callback = $callback;
        return $this;
    }
    
    public function getConstructor()
    {
        return $this->callback;
    }
}