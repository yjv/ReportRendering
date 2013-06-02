<?php
namespace Yjv\ReportRendering\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface TypeChainInterface extends \Traversable
{
    const ITERATION_DIRECTION_PARENT_FIRST = 'parent_first';
    const ITERATION_DIRECTION_CHILD_FIRST = 'child_first';
    const EXCLUSION_STRATEGY_NONE = 'exclude_none';
    const EXCLUSION_STRATEGY_TYPES = 'exclude_types';
    const EXCLUSION_STRATEGY_TYPE_EXTENSIONS = 'exclude_type_extensions';

    public function setIterationDirection($direction);
    public function setExclusionStrategy($strategy);
    public function getOptionsResolver();
    public function getOptions(OptionsResolverInterface $optionsResolver, array $options);
    public function getBuilder(TypeFactoryInterface $factory, array $options);
    public function build(BuilderInterface $builder, array $options);
    public function finalize($object, array $options);
}
