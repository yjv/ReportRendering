<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/8/14
 * Time: 11:10 PM
 */

namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Builder;


use Mockery;
use Yjv\ReportRendering\Datasource\CallbackDatasource;
use Yjv\ReportRendering\Datasource\Extension\Core\Builder\CallbackBuilder;
use Yjv\TypeFactory\Tests\AbstractBuilderTest;

/**
 * Class CallbackBuilderTest
 * @package Yjv\ReportRendering\Tests\Datasource\Extension\Core\Builder
 *
 * @property CallbackBuilder $builder
 */
class CallbackBuilderTest extends AbstractBuilderTest
{
    public function setUp()
    {
        parent::setUp();
        $this->builder = new CallbackBuilder($this->factory, $this->options);
    }

    public function testGettersSetters()
    {
        parent::testGettersSetters();
        $this->assertSame($this->builder, $this->builder->setParams($params = array('value1', 'value2')));
        $this->assertEquals($params, $this->builder->getParams());
        $this->assertSame($this->builder, $this->builder->setCallback($callback = array($this, 'testGettersSetters')));
        $this->assertEquals($callback, $this->builder->getCallback());
    }

    public function testBuild()
    {
        $this->builder = new CallbackBuilder($this->factory, $this->options);
        $this->builder
            ->setCallback($callback = array($this, 'testGettersSetters'))
            ->setParams($params = array('value1', 'value2'))
        ;
        $this->assertEquals(new CallbackDatasource($callback, $params), $this->builder->build());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The callable callback is required to build the callback datasource
     */
    public function testBuildWithNoCallback()
    {
        $this->builder->build();
    }
}
 