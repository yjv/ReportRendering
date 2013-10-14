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
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::setOption()
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::getOption()
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::getOptions()
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::setOptions()
     */
    public function setOptions(array $options) {

        $this->options = $options;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::getFactory()
     */
    public function getFactory()
    {
        return $this->factory;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::setTypeChain()
     */
    public function setTypeChain(TypeChainInterface $typeChain)
    {
        $this->typeChain = $typeChain;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Yjv\ReportRendering\Factory\BuilderInterface::getTypeChain()
     */
    public function getTypeChain()
    {
        return $this->typeChain;
    }
}
