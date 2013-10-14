<?php
namespace Yjv\ReportRendering\Report;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryInterface;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;

use Yjv\ReportRendering\Factory\AbstractFactoryBuilder;

class RendererFactoryBuilder extends AbstractFactoryBuilder
{
    protected $columnFactoryBuilder;
    
    public function getColumnFactoryBuilder()
    {
        if (!$this->columnFactory) {
            
            $this->columnFactory = $this->getDefaultColumnFactoryBuilder();
        }
        
        return $this->columnFactory;
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
