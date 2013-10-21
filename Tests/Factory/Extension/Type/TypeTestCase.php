<?php
namespace Yjv\ReportRendering\Tests\Factory\Extension\Type;

use Yjv\ReportRendering\Factory\TypeResolver;

use Yjv\ReportRendering\DataTransformer\DataTransformerRegistry;

use Yjv\ReportRendering\Factory\TypeRegistry;

class TypeTestCase extends \PHPUnit_Framework_TestCase
{
	protected $builder;
	protected $factory;
	protected $resolver;
	protected $registry;
	protected $type;
	
	protected function setUp()
	{
		$this->registry = new TypeRegistry();
		$this->resolver = new TypeResolver($this->registry);
		
		foreach ($this->getExtensions() as $extension) {
		    
    		$this->registry->addExtension($extension);
		}
	}
	
	protected function getExtensions()
	{
	    return array();
	}
}
