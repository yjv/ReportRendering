<?php
namespace Yjv\ReportRendering\Factory;

abstract class AbstractExtension implements RegistryExtensionInterface
{
    protected $types;
    protected $typeExtensions;
    
    public function hasType($name)
    {
        $this->initTypes();
        return isset($this->types[$name]);
    }
    
    public function getType($name)
    {
        if (!$this->hasType($name)) {
            
            throw new TypeNotFoundException($name);
        }
        
        return $this->types[$name];
    }
    
    public function hasTypeExtensions($name)
    {
        $this->initTypeExtensions();
        return isset($this->typeExtensions[$name]);
    }
    
    public function getTypeExtensions($name)
    {
        return $this->hasTypeExtensions($name) ? $this->typeExtensions[$name] : array();
    }
    
    protected function initTypes()
    {
        if (is_array($this->types)) {
            
            return;
        }
        
        foreach ($this->loadTypes() as $type) {
            
            $this->types[$type->getName()] = $type;
        }
    }
    
    protected function initTypeExtensions()
    {
        if (is_array($this->typeExtensions)) {
            
            return;
        }
        
        foreach($this->loadTypeExtensions() as $typeExtension) {
            
            $this->typeExtensions[$typeExtension->getExtendedType()][] = $typeExtension;
        }
    }
    
    abstract protected function loadTypes();
    abstract protected function loadTypeExtensions();
}
