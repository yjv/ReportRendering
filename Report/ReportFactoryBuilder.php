<?php
namespace Yjv\ReportRendering\Report;
use Yjv\ReportRendering\Renderer\RendererFactoryBuilder;

use Yjv\ReportRendering\Datasource\DatasourceFactoryBuilder;

use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

class ReportFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $rendererFactoryBuilder;
    protected $datasourceFactoryBuilder;
    
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
    
    public function getDatasourceFactoryBuilder()
    {
        if (!$this->datasourceFactoryBuilder) {
            
            $this->datasourceFactoryBuilder = $this->getDefaultDatasourceFactoryBuilder();
        }
        
        return $this->datasourceFactoryBuilder;
    }
    
    public function setDatasourceFactoryBuilder(DatasourceFactoryBuilder $datasourceFactoryBuilder)
    {
        $this->datasourceFactoryBuilder = $datasourceFactoryBuilder;
        return $this;
    }
        
    protected function getFactoryInstance()
    {
        return new ReportFactory(
            $this->getTypeResolver(), 
            $this->getDatasourceFactoryBuilder()->build(), 
            $this->getRendererFactoryBuilder()->build()
        );
    }
    
    protected function getDefaultRendererFactoryBuilder()
    {
        return RendererFactoryBuilder::getInstance();
    }
    
    protected function getDefaultDatasourceFactoryBuilder()
    {
        return DatasourceFactoryBuilder::getInstance();
    }
}
