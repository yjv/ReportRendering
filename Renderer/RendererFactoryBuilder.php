<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Renderer\RendererFactory;

use Yjv\ReportRendering\Renderer\Grid\Column\ColumnFactoryBuilder;

use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

class RendererFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $columnFactoryBuilder;

    /**
     * @return ColumnFactoryBuilder
     */
    public function getColumnFactoryBuilder()
    {
        if (!$this->columnFactoryBuilder) {
            
            $this->columnFactoryBuilder = $this->getDefaultColumnFactoryBuilder();
        }
        
        return $this->columnFactoryBuilder;
    }

    /**
     * @param ColumnFactoryBuilder $columnFactoryBuilder
     * @return $this
     */
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
