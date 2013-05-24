<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Type;

use Yjv\Bundle\ReportRenderingBundle\Report\RendererBuilder;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface;

use Yjv\Bundle\ReportRenderingBundle\Report\RendererBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Yjv\Bundle\ReportRenderingBundle\Renderer\AbstractRendererType;

class RendererType extends AbstractRendererType
{
    /**
    * 
    */
    public function getName() {

        return 'renderer';
    }

    /**
     * @return boolean
     */
    public function getParent() {

        return null;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        
        $resolver
            ->setDefaults(array('constructor' => null))
            ->setAllowedTypes(array('constructor' => 'callable'))
        ;
    }
    
    /**
    * @param unknown $builder
    * @param array $options
    */
    public function buildRenderer(RendererBuilderInterface $builder, array $options) {

        $builder->setConstructor($options['constructor']);
    }
    
    public function createBuilder(TypeFactoryInterface $factory, array $options){
        
        $builder = new RendererBuilder($factory);
        $builder->setOptions($options);
        return $builder;
    }
}
