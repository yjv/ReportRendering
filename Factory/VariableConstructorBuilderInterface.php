<?php
namespace Yjv\ReportRendering\Factory;

use Yjv\ReportRendering\Factory\BuilderInterface;

interface VariableConstructorBuilderInterface extends BuilderInterface
{
    public function setConstructor($callback);
    public function getConstructor();
}
