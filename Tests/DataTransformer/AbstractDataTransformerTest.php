<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\DataTransformer;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\Config\Config;

use Yjv\Bundle\ReportRenderingBundle\DataTransformer\AbstractDataTransformer;

class AbstractDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    protected $transformer;
    
    public function setUp()
    {
        $this->transformer = new TestAbstractDataTransformer();
    }
    
    public function testGettersSetters()
    {
        $this->assertEquals(new Config(array()), $this->transformer->getConfig());
        $this->assertSame($this->transformer, $this->transformer->setConfig(array('key' => 'value')));
        $this->assertEquals(new Config(array('key' => 'value')), $this->transformer->getConfig());
        $config = new Config(array('key' => 'value'));
        $this->assertSame($this->transformer, $this->transformer->setConfig($config));
        $this->assertSame($config, $this->transformer->getConfig());
    }
}

class TestAbstractDataTransformer extends AbstractDataTransformer
{
    public function transform($data, $originalData)
    {
    }
}