<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Factory;
use Yjv\Bundle\ReportRenderingBundle\Factory\TypeExtensionNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeNotFoundException;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeExtensionInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\RegistryExtensionInterface;

class TestExtension implements RegistryExtensionInterface
{
    protected $types = array();
    protected $typeExtensions = array();
    
    public function addType(TypeInterface $type)
    {
        $this->types[$type->getName()] = $type;
        return $this;
    }
    
    public function addTypeExtension(TypeExtensionInterface $typeExtension)
    {
        $name = $typeExtension->getExtendedType();
        
        if (!isset($this->typeExtensions[$name])) {
            
            $this->typeExtensions[$name] = array();
        }
        
        $this->typeExtensions[$name][] = $typeExtension;
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
        
        return $this->types[$name];
    }
    
    public function hasTypeExtensions($name)
    {
        return isset($this->typeExtensions[$name]);
    }
    
    public function getTypeExtensions($name)
    {
        if (!$this->hasTypeExtensions($name)) {
            
            throw new TypeExtensionNotFoundException($name);
        }
        
        return $this->typeExtensions[$name];
    }
}
