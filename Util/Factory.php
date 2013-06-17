<?php
namespace Yjv\ReportRendering\Util;

use Symfony\Component\OptionsResolver\Options;

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
    
    public static function normalizeOptionsCollectionToFactoryArguments(Options $options, $objects)
    {
        return array_map(
            array('static', 'normalizeToFactoryArguments'), 
            $objects
        );
    }
}
