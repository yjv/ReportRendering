<?php
namespace Yjv\ReportRendering\Tests\Util;

use Yjv\ReportRendering\Util\Factory;

use Mockery;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testNormalizeToFactoryArguments()
    {
        $this->assertEquals(
            array('object', array('key' => 'value')), 
            Factory::normalizeToFactoryArguments(array('object', array('key' => 'value')))
        );
        $this->assertEquals(
            array('object', array()), 
            Factory::normalizeToFactoryArguments(array('object'))
        );
        $this->assertEquals(
            array('object', array()), 
            Factory::normalizeToFactoryArguments('object')
        );
    }
    
    public function test()
    {
        $collection = array(
            
            'object1' => array('object', array('key' => 'value')),
            'object2' => array('object'),
            'object3' => 'object'
        );
        $expectedCollection = array(
            
            'object1' => array('object', array('key' => 'value')),
            'object2' => array('object', array()),
            'object3' => array('object', array())
        );
        
        $this->assertEquals(
            $expectedCollection, 
            Factory::normalizeOptionsCollectionToFactoryArguments(
                Mockery::mock('Symfony\Component\OptionsResolver\Options'), 
                $collection
            )
        );
    }
}
