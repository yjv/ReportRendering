<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\TypeFactory\TypeFactoryInterface;

use Yjv\TypeFactory\BuilderInterface;

use Yjv\TypeFactory\AbstractType;

abstract class AbstractRendererType extends AbstractType
{
    final public function build(BuilderInterface $builder, array $options)
    {
        $this->buildRenderer($builder, $options);
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