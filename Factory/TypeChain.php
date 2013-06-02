<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeChain implements \Iterator, TypeChainInterface
{
    protected $index = 0;
    protected $types = array();
    protected $iterationDirection = TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN;

    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function setIterationDirection($direction)
    {
        $this->iterationDirection = $direction;
    }

    public function rewind()
    {
        $this->index = $this->iterationDirection == TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN ? 0 : (count($this->types) - 1);
    }

    public function current()
    {
        return $this->types[$this->index];
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->iterationDirection  == TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN ? $this->index++ : $this->index--;
    }

    public function valid()
    {
        return isset($this->types[$this->index]);
    }

    public function getOptionsResolver()
    {
        $this->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
    
        $optionsResolver = null;
        
        foreach ($this as $type) {
    
            if ($optionsResolver = $type->getOptionsResolver()) {
    
                break;
            }
        }
    
        return $optionsResolver;
    }
    
    public function getOptions(OptionsResolverInterface $optionsResolver, array $options)
    {
        $this->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
    
        foreach ($this as $type) {
    
            $type->setDefaultOptions($optionsResolver);
        }
    
        return $optionsResolver->resolve($options);
    }
    
    public function getBuilder(TypeFactoryInterface $factory, array $options)
    {
        $this->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
    
        $builder = null;
        
        foreach ($this as $type) {
    
            if ($builder = $type->createBuilder($factory, $options)) {
    
                break;
            }
        }
    
        return $builder;
    }
    
    public function build(BuilderInterface $builder, array $options)
    {
        $this->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
    
        foreach ($this as $type) {
    
            $type->build($builder, $options);
        }
    
        return $builder;
    }
    
    public function finalize($object, array $options)
    {
        $this->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
    
        foreach ($this as $type) {
    
            if ($type instanceof FinalizingTypeInterface) {
    
                $type->finalize($object, $options);
            }
        }
    
        return $object;
    }
}
