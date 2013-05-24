<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeRegistry implements TypeRegistryInterface
{
    protected $types = array();
    protected $typeName;

    public function __construct($typeName = null)
    {
        $this->typeName = $typeName;
    }

    public function add(TypeInterface $type)
    {
        if ($this->typeName && !$type instanceof $this->typeName) {

            throw new TypeNotSupportedException($type, $this->typeName);
        }

        $this->types[$type->getName()] = $type;
        return $this;
    }

    public function get($name)
    {
        if (!$this->has($name)) {

            throw new TypeNotFoundException($this->typeName, $name);
        }

        return $this->types[$name];
    }

    public function all()
    {
        return $this->types;
    }

    public function has($name)
    {
        return isset($this->types[$name]);
    }
}
