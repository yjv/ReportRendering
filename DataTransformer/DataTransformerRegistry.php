<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\DataTransformer\DataTransformerNotFoundException;

class DataTransformerRegistry
{
    protected $dataTransformers = array();

    public function set($name, DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformers[$name] = $dataTransformer;
        return $this;
    }

    public function get($name)
    {
        if (!isset($this->dataTransformers[$name])) {

            throw new DataTransformerNotFoundException($name);
        }

        return clone $this->dataTransformers[$name];
    }
}
