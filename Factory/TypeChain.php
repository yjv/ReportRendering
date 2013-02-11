<?php
namespace Yjv\Bundle\ReportRenderingBundle\Factory;

class TypeChain implements \Iterator, TypeChainInterface{

	protected $index = 0;
	protected $types = array();
	protected $iterationDirection = TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN;
	
	public function __construct(array $types) {
		
		$this->types = $types;
	}
	
	public function setIterationDirection($direction){
		
		$this->iterationDirection = $direction;
	}
	
	public function rewind() {
		
		$this->index = $this->iterationDirection == TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN ? 0 : (count($this->types) - 1);
	}
	
	public function current() {
		
		return $this->types[$this->index];
	}
	
	public function key() {
		
		return $this->index;
	}
	
	public function next() {
		
		$this->iterationDirection == TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN ? $this->index++ : $this->index--;
	}
	
	public function valid() {
		
		return isset($this->types[$this->index]);
	}
}
