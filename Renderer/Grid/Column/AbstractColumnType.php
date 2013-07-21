<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Yjv\ReportRendering\Factory\AbstractType;
use Yjv\ReportRendering\Factory\TypeFactoryInterface;
use Yjv\ReportRendering\Factory\TypeInterface;

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
