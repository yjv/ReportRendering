<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

interface TypeChainInterface extends \Traversable{

	const ITERATION_DIRECTION_TOP_DOWN = 'top_down';
	const ITERATION_DIRECTION_BOTTOM_UP = 'bottom_up';
	
	public function setIterationDirection($direction);
}
