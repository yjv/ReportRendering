<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;
use Yjv\TypeFactory\TypeFactory;

class ColumnFactory extends TypeFactory implements ColumnFactoryInterface
{
    protected $dataTransformerRegistry;

    public function __construct(TypeResolverInterface $typeResolver, DataTransformerRegistry $dataTransformerRegistry)
    {
        $this->dataTransformerRegistry = $dataTransformerRegistry;
        parent::__construct($typeResolver);
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface';
    }

    public function getDataTransformerRegistry()
    {
        return $this->dataTransformerRegistry;
    }
}
