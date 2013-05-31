<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeExtensionsNotFoundException extends TypeNotFoundException
{
    protected $message = 'type extensions for type with name "%s" not found';
    protected $typedMessage = 'type extensions of class "%s" for type with name "%s" not found';
}
