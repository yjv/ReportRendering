<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface TypeRegistryInterface
{
    public function get($name);
    public function has($name);
}
