<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;

use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;

use Mockery;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    protected $widgetRenderer;
    protected $extensionWithRenderer;
    
    public function setUp()
    {
        $this->widgetRenderer = Mockery::mock('Yjv\ReportRendering\Widget\WidgetRenderer');
        $this->extension = new CoreExtension();
        $this->extensionWithRenderer = new CoreExtension($this->widgetRenderer);
    }
    
    public function testTypesThereWithoutWidgetRenderer()
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
    
    public function testHtmlTypeThereWithWidgetRenderer()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType', 
            $this->extensionWithRenderer->getType('html')
        );
    }
}
