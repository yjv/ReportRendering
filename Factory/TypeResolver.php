<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeResolver implements TypeResolverInterface
{
    protected $registry;
    
    public function __construct(TypeRegistryInterface $registry)
    {
        $this->registry = $registry;
    }
    
    public function resolveTypeChain($type)
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

        return $this->registry->getType((string) $type);
    }

    public function getTypeRegistry()
    {
        return $this->registry;
    }
}
