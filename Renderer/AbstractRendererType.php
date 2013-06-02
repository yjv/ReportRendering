<?php
namespace Yjv\ReportRendering\Renderer;

use Yjv\ReportRendering\Report\RendererBuilderInterface;

use Yjv\ReportRendering\Factory\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\ReportRendering\Factory\TypeInterface;

abstract class AbstractRendererType extends AbstractType
{
    final public function build($builder, array $options)
    {
        return $this->buildRenderer($builder, $options);
    }

    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return 'renderer';
    }

}
