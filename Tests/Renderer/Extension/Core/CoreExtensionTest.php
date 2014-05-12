<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/11/14
 * Time: 8:07 PM
 */

namespace Yjv\ReportRendering\Tests\Renderer\Extension\Core;


use Mockery\MockInterface;
use Yjv\ReportRendering\Renderer\Extension\Core\CoreExtension;

class CoreExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var CoreExtension  */
    protected $extension;
    /** @var  MockInterface */
    protected $templating;
    /** @var  MockInterface */
    protected $extensionWithTemplating;

    public function setUp()
    {
        $this->extension = new CoreExtension();
        $this->templating = \Mockery::mock('Symfony\Component\Templating\EngineInterface');
        $this->extensionWithTemplating = new CoreExtension($this->templating);
    }

    public function testTypesThere()
    {
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\RendererType',
            $this->extension->getType('renderer')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\GriddedType',
            $this->extension->getType('gridded')
        );
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\CsvType',
            $this->extension->getType('csv')
        );
        $this->assertFalse($this->extension->hasType('html'));
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Core\Type\HtmlType',
            $this->extensionWithTemplating->getType('html')
        );
    }
} 