<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Type;

use Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType;


use Mockery;

class RendererTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new RendererType();
    }
    
    public function testGetName()
    {
        $this->assertEquals('renderer', $this->type->getName());
    }
    
    public function testGetParent()
    {
        $this->assertFalse($this->type->getParent());
    }
}
