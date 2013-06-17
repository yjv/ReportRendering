<?php
namespace Yjv\ReportRendering\Util;

class Factory
{
    public static function normalizeToFactoryArguments($object)
    {
        if(!is_array($object)){
                        
            $object = array($object, array());
        }
        
        if (count($object) == 1) {
        
            $object[] = array();
        }
        
        return $object;
    }
}
