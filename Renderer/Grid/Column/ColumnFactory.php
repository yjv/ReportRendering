<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\TypeFactory\TypeResolverInterface;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;
use Yjv\TypeFactory\AbstractTypeFactory;

class ColumnFactory extends AbstractTypeFactory implements ColumnFactoryInterface
{
    protected $dataTransformerRegistry;

    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getColumn();
    }

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
