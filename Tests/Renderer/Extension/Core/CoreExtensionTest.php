<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;

use Mockery;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    protected $renderer;
    protected $extensionWithRenderer;
    
    public function setUp()
    {
        $this->renderer = Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->extension = new CoreExtension();
        $this->extensionWithRenderer = new CoreExtension($this->renderer);
    }
    
    public function testTypesThereWithoutRenderer()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType', 
            $this->extension->getType('renderer')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType', 
            $this->extension->getType('gridded')
        );
        $this->assertFalse($this->extension->hasType('html'));
    }
    
    public function testHtmlTypeThereWithRenderer()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType', 
            $this->extensionWithRenderer->getType('html')
        );
    }
}
