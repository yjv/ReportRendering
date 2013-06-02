<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeChainInterface extends \Traversable
{
    const ITERATION_DIRECTION_TOP_DOWN = 'top_down';
    const ITERATION_DIRECTION_BOTTOM_UP = 'bottom_up';

    public function setIterationDirection($direction);
    public function getOptionsResolver();
    public function getOptions(OptionsResolverInterface $optionsResolver, array $options);
    public function getBuilder(TypeFactoryInterface $factory, array $options);
    public function build(BuilderInterface $builder, array $options);
    public function finalize($object, array $options);
}
