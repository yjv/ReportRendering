<?php
namespace Yjv\ReportRendering\Tests\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Yjv\ReportRendering\Datasource\DatasourceFactory;

use Yjv\ReportRendering\Datasource\Extension\Core\CoreExtension;

use Yjv\TypeFactory\Tests\Extension\Type\TypeTestCase as BaseTypeTestCase;

use Mockery;

class TypeTestCase extends BaseTypeTestCase
{
    protected function setUp()
	{
	    parent::setUp();
	    $this->factory = new DatasourceFactory($this->resolver);
		$this->builder = new DatasourceBuilder($this->factory);
	}
	
	protected function getExtensions()
	{
	    return array(new CoreExtension());
	}
}
