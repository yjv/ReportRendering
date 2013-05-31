<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface BuilderInterface
{
    public function setOption($name, $value);
    public function getOption($name, $default = null);
    public function getOptions();
    public function setOptions(array $options);
}