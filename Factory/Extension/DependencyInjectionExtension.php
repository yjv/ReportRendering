<?php
namespace Yjv\ReportRendering\Factory\Extension;
use Yjv\ReportRendering\Factory\TypeNotFoundException;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Yjv\ReportRendering\Factory\RegistryExtensionInterface;

class DependencyInjectionExtension implements RegistryExtensionInterface
{
    protected $types = array();
    protected $typeExtensions = array();
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    public function addType($name, $service)
    {
        $this->types[$name] = $service;
        return $this;
    }
    
    public function addTypeExtension($typeName, $service)
    {
        if (!isset($this->typeExtensions[$typeName])) {
            
            $this->typeExtensions[$typeName] = array();
        }
        
        $this->typeExtensions[$typeName][] = $service;
        return $this;
    }
    
    public function hasType($name)
    {
        return isset($this->types[$name]);
    }
    
    public function getType($name)
    {
        if (!$this->hasType($name)) {
            
            throw new TypeNotFoundException($name);
        }
        
        $type = $this->types[$name];
        
        if (is_string($type)) {
            
            $this->types[$name] = $type = $this->container->get($type);
        }
        
        return $type;
    }
    
    public function hasTypeExtensions($name)
    {
        return isset($this->typeExtensions[$name]);
    }
    
    public function getTypeExtensions($name)
    {
        $typeExtensions = $this->hasTypeExtensions($name) ? $this->typeExtensions[$name] : array();
        
        if (is_string(reset($typeExtensions))) {
            
            $container = $this->container;
            
            $this->typeExtensions[$name] = 
            $typeExtensions = array_map(function($value) use ($container){
                return $container->get($value);
            }, $typeExtensions);
        }
        
        return $typeExtensions;
    }
}
