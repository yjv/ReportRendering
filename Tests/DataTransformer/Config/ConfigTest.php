<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer\Config;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected $config;
    
    public function setUp()
    {
        $this->config = new Config(array('key' => 'value'));
    }
    
    public function testGet()
    {
        $this->assertEquals('value', $this->config->get('key'));
        $this->assertEquals('value2', $this->config->get('key2', 'value2'));
    }
    
    /**
     * @expectedException Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\ConfigValueRequiredException
     * @expectedExceptionMessage The config option "key2" must be set.
     */
    public function testGetWithRequiredValue()
    {
        $this->config->get('key2');
    }
}
