<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;

use Yjv\ReportRendering\Factory\AbstractTypeFactoryBuilder;

class RendererFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $columnFactoryBuilder;
    
    public function getColumnFactoryBuilder()
    {
        if (!$this->columnFactoryBuilder) {
            
            $this->columnFactoryBuilder = $this->getDefaultColumnFactoryBuilder();
        }
        
        return $this->columnFactoryBuilder;
    }
    
    public function setColumnFactoryBuilder(ColumnFactoryBuilder $columnFactoryBuilder)
    {
        $this->columnFactoryBuilder = $columnFactoryBuilder;
        return $this;
    }
    
    protected function getFactoryInstance()
    {
        return new RendererFactory($this->getTypeResolver(), $this->getColumnFactoryBuilder()->build());
    }
    
    protected function getDefaultColumnFactoryBuilder()
    {
        return ColumnFactoryBuilder::getInstance();
    }
}
