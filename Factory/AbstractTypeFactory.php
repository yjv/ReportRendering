<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractTypeFactory implements TypeFactoryInterface
{
    protected $typeResolver;

    public function __construct(TypeResolverInterface $typeResolver)
    {
        $this->typeResolver = $typeResolver;
    }

    public function createBuilder($type, array $options = array())
    {
        $typeChain = $this->getTypeChain($type);
        $optionsResolver = $this->getOptionsResolver($typeChain);
        $options = $this->getOptions($typeChain, $optionsResolver, $options);
        $builder = $this->getBuilder($typeChain, $options);
        $this->build($typeChain, $builder, $options);

        return $builder;
    }

    public function getTypeChain($type)
    {
        return $this->typeResolver->resolveTypeChain($type);
    }

    public function getTypeRegistry()
    {
        return $this->typeResolver->getTypeRegistry();
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\Bundle\ReportRenderingBundle\Factory\TypeFactoryInterface::getBuilderInterfaceName()
     * @codeCoverageIgnore
     */
    public function getBuilderInterfaceName() {

        return 'Yjv\Bundle\ReportRenderingBundle\Factory\BuilderInterface';
    }

    protected function getOptionsResolver(TypeChainInterface $typeChain)
    {
        if (!$optionsResolver = $typeChain->getOptionsResolver()) {

            throw new OptionsResolverNotReturnedException();
        }

        return $optionsResolver;
    }

    protected function getOptions(
        TypeChainInterface $typeChain, 
        OptionsResolverInterface $optionsResolver, 
        array $options
    ) {
        return $typeChain->getOptions($optionsResolver, $options);
    }

    protected function getBuilder(TypeChainInterface $typeChain, array $options)
    {
        if (!$builder = $typeChain->getBuilder($this, $options)) {
            
            throw new BuilderNotReturnedException();
        }
        
        $requiredInterface = $this->getBuilderInterfaceName();
        
        if (!$builder instanceof $requiredInterface) {
        
            throw new BuilderNotSupportedException($builder, $requiredInterface);
        }
        
        return $builder;
    }

    protected function build(TypeChainInterface $typeChain, $builder, array $options)
    {
        $typeChain->build($builder, $options);
    }
}
