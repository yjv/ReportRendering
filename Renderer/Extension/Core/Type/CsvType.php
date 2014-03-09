<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Extension\Core\Builder\CsvBuilder;
use Yjv\ReportRendering\Renderer\AbstractRendererType;
use Yjv\TypeFactory\TypeFactoryInterface;

class CsvType extends AbstractRendererType
{
    public function getName()
    {
        return 'csv';
    }
    
    public function getParent()
    {
        return 'gridded';
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        return new CsvBuilder($factory, $options);
    }
}
