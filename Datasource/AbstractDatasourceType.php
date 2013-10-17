<?php
namespace Yjv\ReportRendering\Datasource;

use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Yjv\ReportRendering\Factory\AbstractType;

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