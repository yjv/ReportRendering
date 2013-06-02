<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

use Yjv\Bundle\ReportRenderingBundle\Factory\RegistryExtensionInterface;

class TypeRegistry implements TypeRegistryInterface
{
    protected $types = array();
    protected $typeExtensions = array();
    protected $extensions = array();
    protected $typeName;

    public function __construct($typeName = null)
    {
        $this->typeName = $typeName;
    }
    
    public function getType($name)
    {
        if (!$this->hasType($name)) {

            throw new TypeNotFoundException($name, $this->typeName);
        }

        return $this->types[$name];
    }

    public function hasType($name)
    {
        $this->resolveFromExtensions($name);
        return isset($this->types[$name]);
    }
    
    public function getTypeExtensions($name){
        
        $this->resolveFromExtensions($name);
        return $this->typeExtensions[$name];
    }
    
    public function hasTypeExtensions($name)
    {
        $this->resolveFromExtensions($name);
        return !empty($this->typeExtensions[$name]);
    }
    
    public function addExtension(RegistryExtensionInterface $extension){
        
        $this->extensions[] = $extension;
        $this->clearResolved();
        return $this;
    }
    
    public function getExtensions(){
        
        return $this->extensions;
    }
    
    public function clearResolved(){
        
        $this->types = array();
        $this->typeExtensions = array();
    }
    
    protected function resolveFromExtensions($name)
    {
        if (isset($this->types[$name])) {
            
            return;
        }
        
        $this->typeExtensions[$name] = array();

        foreach ($this->extensions as $extension) {
            
            if ($extension->hasType($name)) {
                
                $type = $extension->getType($name);

                if ($this->typeName && !$type instanceof $this->typeName) {
        
                    throw new TypeNotSupportedException($type, $this->typeName);
                }
                
                $this->types[$name] = $type;
            }
            
            if ($extension->hasTypeExtensions($name)) {
                
                $this->typeExtensions[$name] = array_merge(
                    $this->typeExtensions[$name], 
                    $extension->getTypeExtensions($name)
                );
            }
        }
    }
}
