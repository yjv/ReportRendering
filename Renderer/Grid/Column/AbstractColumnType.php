<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractType;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractColumnType extends AbstractType implements TypeInterface
{
    final public function build(BuilderInterface $builder, array $options)
    {
        return $this->buildColumn($builder, $options);
    }

    public function buildColumn(ColumnBuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    public function getParent()
    {
        return 'column';
    }
}
