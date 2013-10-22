<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\BuilderInterface;

use Yjv\TypeFactory\AbstractType;

abstract class AbstractDatasourceType extends AbstractType
{
    final public function build(BuilderInterface $builder, array $options)
    {
        return $this->buildDatasource($builder, $options);
    }

    public function buildDatasource(DatasourceBuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    public function getParent()
    {
        return 'datasource';
    }
}