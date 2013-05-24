<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;
use Yjv\Bundle\ReportRenderingBundle\DataTransformer\DataTransformerRegistry;
use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractTypeFactory;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnRegistry;

class ColumnFactory extends AbstractTypeFactory implements ColumnFactoryInterface
{
    protected $registry;
    protected $dataTransformerRegistry;

    public function create($type, array $options = array())
    {
        return $this->createBuilder($type, $options)->getColumn();
    }

    public function __construct(TypeRegistry $columnRegistry, DataTransformerRegistry $dataTransformerRegistry)
    {
        $this->registry = $columnRegistry;
        $this->dataTransformerRegistry = $dataTransformerRegistry;
    }

    public function addType(TypeInterface $type)
    {
        $this->registry->add($type);
        return $this;
    }

    public function getBuilderInterfaceName()
    {
        return 'Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column\ColumnBuilderInterface';
    }

    public function getDataTransformerRegistry()
    {
        return $this->dataTransformerRegistry;
    }
}
