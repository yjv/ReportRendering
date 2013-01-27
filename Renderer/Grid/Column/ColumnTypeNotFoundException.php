<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Grid\Column;

class ColumnTypeNotFoundException extends \Exception{

	public function __construct($name) {
		
		parent::__construct(sprintf('Columntype with name "%s" not found', $name));
	}
}
