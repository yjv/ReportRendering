<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core;

use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension;

use Mockery;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $extension;
    
    public function setUp()
    {
        $this->extension = new CoreExtension();
    }
    
    public function testTypes()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Datasource\Extension\Core\Type\DatasourceType', 
            $this->extension->getType('datasource')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Datasource\Extension\Core\Type\ArrayType', 
            $this->extension->getType('array')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Datasource\Extension\Core\Type\CallbackType', 
            $this->extension->getType('callback')
        );
    }
}
