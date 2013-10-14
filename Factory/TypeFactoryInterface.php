<?php
namespace Yjv\ReportRendering\Factory;

interface TypeFactoryInterface
{
    /**
     * 
     * @param string|TypeInterface $type
     * @return mixed the result of all the types and the builder
     */
    public function create($type, array $options = array());
    
    /**
     * 
     * @param string|TypeInterface $type
     * @return Yjv\ReportRendering\Factory\BuilderInterface
     */
    public function createBuilder($type, array $options = array());
    
    /**
     * 
     * @param string|TypeInterface $type
     * @return Yjv\ReportRendering\Factory\TypeChainInterface
     */
    public function getTypeChain($type);
    
    /**
     * 
     * @return Yjv\ReportRendering\Factory\TypeRegistryInterface
     */
    public function getTypeRegistry();
    
    /**
     * @return string
     */
    public function getBuilderInterfaceName();
}
