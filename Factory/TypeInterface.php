<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeInterface
{
    /**
     * 
     * @param object $builder the object builder
     * @param array $options
     */
    public function build($builder, array $options);

    /**
     * 
     * @param TypeFactoryInterface $factory
     * @param array $options
     * @return BuilderInterface a builder object to use in the type chain
     */
    public function createBuilder(TypeFactoryInterface $factory, array $options);

    /**
     * @return string the name of this type
     */
    public function getName();

    /**
     * @return string|TypeInterface|false the parent of this type false if it has no parent
     */
    public function getParent();

    /**
     * 
     * @param OptionsResolverInterface $resolver the resolver to use to set the option requirements
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * @return OptionsResolverInterface the options resolver to use in this type chain
     */
    public function getOptionsResolver();
}
