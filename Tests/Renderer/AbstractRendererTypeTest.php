<?php
namespace Yjv\ReportRendering\Renderer;

use Mockery;

class AbstractRendererTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $type;
    
    public function setUp()
    {
        $this->type = new TestAbstractRendererType();
    }

    public function testCreateBuilder()
    {
        $this->type->createBuilder(Mockery::mock('Yjv\ReportRendering\Factory\TypeFactoryInterface'), array());
    }
    
    public function testSetDefaultOptions()
    {
        $this->type->setDefaultOptions(Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface'));
    }
    
    public function testBuild()
    {
        $this->type->build(Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface'), array());
        $this->type->buildRenderer(Mockery::mock('Yjv\ReportRendering\Renderer\RendererBuilderInterface'), array());
    }
    
    public function testGetParent()
    {
        $this->assertEquals('renderer', $this->type->getParent());
    }
}

class TestAbstractRendererType extends AbstractRendererType
{
    public function getName(){
        
        return 'test';
    }
}
