<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class BuilderNotSupportedException extends \Exception{

	public function __construct($builder, $requiredInterface){
		
		parent::__construct(sprintf('Builder of class "%s" must implement the interface "%s" to be used in this factory', get_class($builder), $requiredInterface));
	}
}
