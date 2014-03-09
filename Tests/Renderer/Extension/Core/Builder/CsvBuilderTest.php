<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/5/14
 * Time: 10:38 PM
 */

namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core\Builder;


use Mockery;
use Yjv\ReportRendering\Renderer\Csv\CsvRenderer;
use Yjv\ReportRendering\Renderer\Extension\Core\Builder\CsvBuilder;
use Yjv\ReportRendering\Tests\Renderer\AbstractRendererBuilderTest;

class CsvBuilderTest extends AbstractRendererBuilderTest
{
    public function setUp()
    {
        parent::setUp();
        $this->builder = new CsvBuilder($this->factory);
    }

    public function testGetRenderer()
    {
        $grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
        $this->builder->setGrid($grid);
        $this->assertEquals(new CsvRenderer($grid), $this->builder->getRenderer());
    }
}
 