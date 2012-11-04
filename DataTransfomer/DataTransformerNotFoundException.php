<?php
namespace Yjv\Bundle\ReportRenderingBundle\DataTransformer;

class DataTransformerNotFoundException extends \Exception{

	public function __construct($name){
		
		parent::__construct(sprintf('The DataTransformer named "%s" was not found.', $name));
	}
}
