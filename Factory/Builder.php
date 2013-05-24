<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class Builder implements BuilderInterface
{
    protected $options = array();
    
    public function setOption($name, $value)
    {
        $this->options[$name] = $option;
        return $this;
    }
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
    * @param array $options
    */
    public function setOptions(array $options) {

        $this->options = $options;
        return $this;
    }
}
