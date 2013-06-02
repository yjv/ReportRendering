<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\Factory\TypeResolverInterface;

use Yjv\ReportRendering\Factory\TypeInterface;
use Yjv\ReportRendering\Factory\TypeRegistry;
use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;
use Yjv\ReportRendering\Factory\AbstractTypeFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnRegistry;

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
