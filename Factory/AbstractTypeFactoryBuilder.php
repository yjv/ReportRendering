<?php
namespace Yjv\ReportRendering\Factory;

abstract class AbstractTypeFactoryBuilder implements FactoryBuilderInterface
{
    protected $extensions = array();
    protected $typeRegistry;
    protected $typeResolver;
    protected $typeName;

    public static function getInstance()
    {
        return new static();
    }
    
    public function addExtension(RegistryExtensionInterface $extension)
    {
        $this->extensions[] = $extension;
        return $this;
    }
    
    public function setTypeRegistry(TypeRegistryInterface $typeRegistry)
    {
        $this->typeRegistry = $typeRegistry;
        return $this;
    }
    
    public function setTypeResolver(TypeResolverInterface $typeResolver)
    {
        $this->typeResolver = $typeResolver;
        return $this;
    }
    
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
        return $this;
    }
    
    public function getTypeRegistry()
    {
        if (!$this->typeRegistry) {
            
            $this->typeRegistry = $this->getDefaultTypeRegistry();
        }
        
        return $this->typeRegistry;
    }
    
    public function getTypeResolver()
    {
        if (!$this->typeResolver) {
            
            $this->typeResolver = $this->getDefaultTypeResolver();
        }
        
        return $this->typeResolver;
    }
    
    public function getTypeName()
    {
        return $this->typeName;
    }
    
    public function build()
    {
        $factory = $this->getFactoryInstance();
        $typeRegistry = $factory->getTypeRegistry();
        
        foreach ($this->extensions as $extension) {
            
            $typeRegistry->addExtension($extension);
        }
        
        return $factory;
    }
    
    protected function getDefaultTypeRegistry()
    {
        return new TypeRegistry($this->getTypeName());
    }
    
    protected function getDefaultTypeResolver()
    {
        return new TypeResolver($this->getTypeRegistry());
    }
    
    /**
     * @return Yjv\ReportRendering\Factory\TypeFactoryInterface
     */
    abstract protected function getFactoryInstance();
}
