<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeNotSupportedException extends \Exception
{

    public function __construct($type, $requiredInstance)
    {
        parent::__construct(sprintf(
                'Type of class "%s" must be an instance of "%s" to be used in this registry.',
                get_class($type), 
                $requiredInstance
        ));
    }
}
