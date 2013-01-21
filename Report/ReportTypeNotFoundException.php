<?php
namespace Yjv\Bundle\ReportRenderingBundle\Report;

class ReportTypeNotFoundException extends \Exception{

	public function __construct($name) {
		
		parent::__construct(sprintf('Report type with the name "%s" could not be found', $name));
	}
}
