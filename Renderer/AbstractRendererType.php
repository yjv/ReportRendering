<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Yjv\ReportRendering\Factory\BuilderInterface;

use Yjv\ReportRendering\Factory\AbstractType;

abstract class AbstractRendererType extends AbstractType
{
    final public function build(BuilderInterface $builder, array $options)
    {
        return $this->buildRenderer($builder, $options);
    }

    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    public function getParent()
    {
        return 'renderer';
    }
}