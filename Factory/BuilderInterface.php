<?php
namespace Yjv\ReportRendering\Factory;

interface BuilderInterface
{
    public function setOption($name, $value);
    public function getOption($name, $default = null);
    public function getOptions();
    public function setOptions(array $options);
    public function getFactory();
    public function setTypeChain(TypeChainInterface $typeChain);
    public function getTypeChain();
}
