<?php
namespace Yjv\ReportRendering\Factory;

use Yjv\TypeFactory\BuilderInterface;

interface VariableConstructorBuilderInterface extends BuilderInterface
{
    public function setConstructor($callback);
    public function getConstructor();
}
