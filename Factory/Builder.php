<?php
namespace Yjv\ReportRendering\Factory;

class Builder implements BuilderInterface
{
    protected $options;
    protected $factory;
    protected $typeChain;
    
    public function __construct(TypeFactoryInterface $factory, array $options = array()){
        
        $this->factory = $factory;
        $this->options = $options;
    }
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }
    
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
    
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
    * @param array $options
    */
    public function setOptions(array $options) {

        $this->options = $options;
        return $this;
    }
    
    public function getFactory()
    {
        return $this->factory;
    }
    
    public function setTypeChain(TypeChainInterface $typeChain)
    {
        $this->typeChain = $typeChain;
        return $this;
    }
    
    public function getTypeChain()
    {
        return $this->typeChain;
    }
}
