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
    
    public static function normalizeCollectionToFactoryArguments($objects)
    {
        return array_map(
            array('static', 'normalizeToFactoryArguments'), 
            $objects
        );
    }
}
