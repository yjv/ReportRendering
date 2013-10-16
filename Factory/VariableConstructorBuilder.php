<?php
namespace Yjv\ReportRendering\Factory;

class VariableConstructorBuilder extends Builder
{
    protected $callback;

    public function setConstructor($callback)
    {
        if (!is_callable($callback)) {
    
            throw new \InvalidArgumentException('$callback must a valid callable.');
        }
    
        $this->callback = $callback;
        return $this;
    }
    
    public function getConstructor()
    {
        return $this->callback;
    }    
}
