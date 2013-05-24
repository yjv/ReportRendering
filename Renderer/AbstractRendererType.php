<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer;

use Yjv\Bundle\ReportRenderingBundle\Report\RendererBuilderInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

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
