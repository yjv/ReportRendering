<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\TypeFactory\TypeFactoryInterface;
use Yjv\ReportRendering\Renderer\RendererBuilderInterface;
use Yjv\ReportRendering\Renderer\AbstractRendererType;

class RendererType extends AbstractRendererType
{
    /**
     *
     */
    public function getName()
    {
        return 'renderer';
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return false;
    }

    /**
     * @param RendererBuilderInterface $builder
     * @param array $options
     */
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }
}
