<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;
use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

class ColumnFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $dataTransformerRegistry;
    protected $dataTransformers = array();
    
    public function setDataTransformerRegistry(DataTransformerRegistry $dataTransformerRegistry)
    {
        $this->dataTransformerRegistry = $dataTransformerRegistry;
        return $this;
    }
    
    public function getDataTransformerRegistry()
    {
        if (!$this->dataTransformerRegistry) {
            
            $this->dataTransformerRegistry = $this->getDefaultDataTransformerRegistry();
        }
        
        return $this->dataTransformerRegistry;
    }

    public function addDataTransformer($name, DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformers[$name] = $dataTransformer;
        return $this;
    }
    
    protected function getFactoryInstance()
    {
        $dataTransformerRegistry = $this->getDataTransformerRegistry();

        foreach ($this->dataTransformers as $name =>$dataTransformer) {

            $dataTransformerRegistry->set($name ,$dataTransformer);
        }

        return new ColumnFactory($this->getTypeResolver(), $dataTransformerRegistry);
    }
    
    protected function getDefaultDataTransformerRegistry()
    {
        return new DataTransformerRegistry();
    }
}
