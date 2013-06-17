<?php
namespace Yjv\ReportRendering\Tests\Util;

use Yjv\ReportRendering\Util\Factory;

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
}
