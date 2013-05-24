<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeNotFoundException extends \Exception
{
    public function __construct($typeName, $name)
    {
        parent::__construct(sprintf('type "%s" with name "%s" not found', $typeName, $name));
    }
}
