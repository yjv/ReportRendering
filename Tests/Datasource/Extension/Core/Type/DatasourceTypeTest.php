<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\Extension\Core\Type\DatasourceType;
use Mockery;

/**
 * Class DatasourceTypeTest
 * @package Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type
 *
 * @property DatasourceType $type
 */
class DatasourceTypeTest extends TypeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->type = new DatasourceType();
    }
    
    public function testGetName()
    {
        $this->assertEquals('datasource', $this->type->getName());
    }
    
    public function testGetParent()
    {
        $this->assertFalse($this->type->getParent());
    }
}
