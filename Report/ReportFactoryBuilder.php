<?php
namespace Yjv\ReportRendering\Report;
use Yjv\ReportRendering\Factory\AbstractFactoryBuilder;

class ReportFactoryBuilder extends AbstractFactoryBuilder
{
    protected $rendererFactoryBuilder;
    
    public function getRendererFactoryBuilder()
    {
        if (!$this->rendererFactoryBuilder) {
    
            $this->rendererFactoryBuilder = $this->getDefaultRendererFactoryBuilder();
        }
    
        return $this->rendererFactoryBuilder;
    }
    
    public function setRendererFactoryBuilder(RendererFactoryBuilder $rendererFactoryBuilder)
    {
        $this->rendererFactoryBuilder = $rendererFactoryBuilder;
        return $this;
    }
        
    protected function getFactoryInstance()
    {
        return new ReportFactory($this->getTypeResolver(), $this->getRendererFactoryBuilder()->build());
    }
    
    protected function getDefaultRendererFactoryBuilder()
    {
        return RendererFactoryBuilder::getInstance();
    }
}
