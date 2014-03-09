<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Extension\Core\Builder\CsvBuilder;
use Yjv\ReportRendering\Renderer\Extension\Core\Type\CsvType;
use Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type\TypeTestCase;
use Mockery;

/**
 * Class CsvTypeTest
 * @package Yjv\ReportRendering\Tests\Renderer\Extension\Core
 *
 * @property CsvType $type
 */
class CsvTypeTest extends TypeTestCase
{
    protected $widgetRenderer;
    protected $formFactory;
    
    public function setUp()
    {
        parent::setUp();
        $this->type = new CsvType();
    }
        
    public function testGetName()
    {
        $this->assertEquals('csv', $this->type->getName());
    }
    
    public function testGetParent()
    {
        $this->assertEquals('gridded', $this->type->getParent());
    }

    public function testCreateBuilder()
    {
        $factory = Mockery::mock('Yjv\TypeFactory\TypeFactoryInterface');
        $options = array('key' =>' value');
        $this->assertEquals(new CsvBuilder($factory, $options), $this->type->createBuilder($factory, $options));
    }

}
