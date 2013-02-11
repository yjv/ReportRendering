<?php
namespace Yjv\Bundle\ReportRenderingBundle\Tests\Renderer\Grid\Column;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChainInterface;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeChain;

use Yjv\Bundle\ReportRenderingBundle\Factory\TypeRegistry;

class TypeChainTest extends \PHPUnit_Framework_TestCase{

	protected $chain;
	protected $types;
	
	/**
	 * 
	 */
	protected function setUp() {

		$this->types = array('hello', 'goodbye', 'seeya');
		$this->chain = new TypeChain($this->types);
	}
	
	public function testIteration() {
		
		$this->assertSame($this->types, iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_BOTTOM_UP);
		$this->assertSame(array_reverse($this->types, true), iterator_to_array($this->chain));
		$this->chain->setIterationDirection(TypeChainInterface::ITERATION_DIRECTION_TOP_DOWN);
		$this->assertSame($this->types, iterator_to_array($this->chain));
	}
}
