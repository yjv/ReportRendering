<?php
namespace Yjv\ReportRendering\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\RendererBuilder;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Yjv\ReportRendering\Renderer\RendererBuilderInterface;

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
        return false;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array('constructor' => null))
            ->setAllowedTypes(array('constructor' => array('callable', 'null')))
        ;
    }

    /**
     * @param unknown $builder
     * @param array $options
     */
    public function buildRenderer(RendererBuilderInterface $builder, array $options)
    {
        if ($options['constructor']) {
            
            $builder->setConstructor($options['constructor']);
        }
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        $builder = new RendererBuilder($factory, $options);
        return $builder;
    }
}
