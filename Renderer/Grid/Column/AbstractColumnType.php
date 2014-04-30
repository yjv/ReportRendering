<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\TypeFactory\BuilderInterface;

use Yjv\TypeFactory\AbstractType;
use Yjv\TypeFactory\TypeFactoryInterface;
use Yjv\TypeFactory\TypeInterface;

abstract class AbstractColumnType extends AbstractType implements TypeInterface
{
    final public function build(BuilderInterface $builder, array $options)
    {
        $this->buildColumn($builder, $options);
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
