<?php
namespace Yjv\ReportRendering\Tests\Report\Extension\Core;

use Yjv\ReportRendering\Report\Extension\Core\CoreExtension;

use Mockery;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    
    public function setUp()
    {
        $this->extension = new CoreExtension();
    }
    
    public function testTypesThereWithoutWidgetRenderer()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Report\Extension\Core\Type\ReportType', 
            $this->extension->getType('report')
        );
    }
}
