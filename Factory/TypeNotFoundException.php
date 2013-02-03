<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeNotFoundException extends \Exception{

	public function __construct($name) {
		
		parent::__construct(sprintf('type with name "%s" not found', $name));
	}
}
