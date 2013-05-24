<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTypeFactory implements TypeFactoryInterface
{
    protected $registry;
    protected $supportsFinalizing;

    public function __construct(TypeRegistryInterface $registry, $supportsFinalizing = false)
    {
        $this->registry = $registry;
        $this->supportsFinalizing = $supportsFinalizing;
    }

    public function createBuilder($type, array $options = array())
    {
        $typeChain = $this->getTypeChain($type);
        $optionsResolver = $this->getOptionsResolver($typeChain);
        $options = $this->getOptions($typeChain, $optionsResolver, $options);
        $builder = $this->getBuilder($typeChain, $options);
        $object = $this->build($typeChain, $builder, $options);

        if ($this->supportsFinalizing) {

            $object = $this->finalize($object, $typeChain, $options);
        }

        return $object;
    }

    public function getTypeChain($type)
    {
        $type = $this->resolveType($type);
        $types = array($type);

        while ($type = $type->getParent()) {

            $type = $this->resolveType($type);
            array_unshift($types, $type);
        }

        return new TypeChain($types);
    }

    public function resolveType($type)
    {
        if ($type instanceof TypeInterface) {

            return $type;
        }

        return $this->registry->get((string) $type);
    }

    public function getTypeRegistry()
    {
        return $this->registry;
    }
    
    /**
    * 
    */
    public function getBuilderInterfaceName() {

        return 'Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface';
    }

    protected function getOptionsResolver(TypeChainInterface $typeChain)
    {
        $typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);

        foreach ($typeChain as $type) {

            $optionsResolver = $type->getOptionsResolver();

            if ($optionsResolver) {

                break;
            }
        }

        if (!$optionsResolver) {

            throw new OptionsResolverNotReturnedException();
        }

        return $optionsResolver;
    }

    protected function getOptions(
        TypeChainInterface $typeChain, 
        OptionsResolverInterface $optionsResolver, 
        array $options
    ) {

        $typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);

        foreach ($typeChain as $type) {

            $type->setDefaultOptions($optionsResolver);
        }

        return $optionsResolver->resolve($options);
    }

    protected function getBuilder(TypeChainInterface $typeChain, array $options)
    {
        $typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);

        foreach ($typeChain as $type) {

            $builder = $type->createBuilder($this, $options);

            if ($builder) {

                $requiredInterface = $this->getBuilderInterfaceName();

                if (!$builder instanceof $requiredInterface) {

                    throw new BuilderNotSupportedException($builder,
                        $requiredInterface);
                }

                break;
            }
        }

        if (empty($builder)) {

            throw new BuilderNotReturnedException();
        }
        
        return $builder;
    }

    protected function build(TypeChainInterface $typeChain, $builder, array $options)
    {
        $typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);

        foreach ($typeChain as $type) {

            $type->build($builder, $options);
        }

        return $builder;
    }

    protected function finalize($object, TypeChainInterface $typeChain, array $options)
    {
        $typeChain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);

        foreach ($typeChain as $type) {

            if ($type instanceof FinalizingBuilderInterface) {

                $type->finalize($object, $options);
            }
        }

        return $object;
    }
}
