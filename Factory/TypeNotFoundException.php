<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeNotFoundException extends \Exception
{
    protected $message = 'type with name "%s" not found';
    protected $typedMessage = 'type of class "%s" with name "%s" not found';
    
    public function __construct($name, $typeName = null)
    {
        if ($typeName) {
            
            $message = sprintf($this->typedMessage, $name);
        } else {
            
            $message = sprintf($this->message, $typeName, $name);
        }
        
        parent::__construct($message);
    }
}
