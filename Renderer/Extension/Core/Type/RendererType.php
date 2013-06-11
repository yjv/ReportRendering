<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Report\RendererBuilder;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Yjv\ReportRendering\Report\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
        return null;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array('constructor' => null))
            ->setAllowedTypes(array('constructor' => 'callable'))
        ;
    }

    /**
     * @param unknown $builder
     * @param array $options
     */
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
        $builder->setConstructor($options['constructor']);
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        $builder = new RendererBuilder($factory, $options);
        return $builder;
    }
}
