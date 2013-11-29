<?php
namespace Yjv\ReportRendering\Tests\Renderer\Grid\Column\Extension\Core;

use Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\CoreExtension;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    
    public function setUp()
    {
        $this->extension = new CoreExtension();
    }
    
    public function testTypesThere()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\ColumnType', 
            $this->extension->getType('column')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\PropertyPathType', 
            $this->extension->getType('property_path')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type\FormatStringType', 
            $this->extension->getType('format_string')
        );
    }
}
