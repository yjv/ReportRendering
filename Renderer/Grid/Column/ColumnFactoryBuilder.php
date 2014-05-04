<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\DataTransformer\DataTransformerInterface;
use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\TypeFactory\AbstractTypeFactoryBuilder;

class ColumnFactoryBuilder extends AbstractTypeFactoryBuilder
{
    protected $dataTransformerRegistry;
    protected $dataTransformers = array();
    
    protected function getFactoryInstance()
    {
        return new ColumnFactory($this->getTypeResolver());
    }
}
