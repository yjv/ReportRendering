<?php
namespace Yjv\ReportRendering\Tests\Datasource;

use Yjv\ReportRendering\Filter\ArrayFilterCollection;

use Yjv\ReportRendering\Datasource\CallbackDatasource;

use Yjv\ReportRendering\ReportData\ReportData;

class CallbackDatasourceTest extends \PHPUnit_Framework_TestCase{

	public function getDataTestDataprovider() {
		
		return array(
			array(array(__NAMESPACE__ . '\\CallbackClass', 'callCallback')),	
			array(__NAMESPACE__ . '\\callback')
		);
	}
	
	public function testContructor(){
		
		$datasource = new CallbackDatasource(array(__NAMESPACE__ . '\\CallbackClass', 'callCallback'));
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		$datasource = new CallbackDatasource(__NAMESPACE__ . '\\callback');
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		$datasource = new CallbackDatasource(function(){return new ReportData(array(), 0);});
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		$datasource = new CallbackDatasource(new \ReflectionFunction(function(){return new ReportData(array(), 0);}));
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		
		$this->setExpectedException('InvalidArgumentException');
		$datasource = new CallbackDatasource('invalidCallback');
	}
	
	public function testCallbackThatReturnsANonInstanceOfReportData() {
		
		$datasource = new CallbackDatasource(__NAMESPACE__ . '\\callbackWithArray');
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
	}
	
	public function testGetData() {
		
		$startParams = array('hello' => 'goodbye');
		$filters = array('thing1' => 'thing2');
		$tester = $this;
		
		$datasource = new CallbackDatasource(function($params) use ($startParams, $tester){
			
			static $callCount = 0;
			$callCount++;
			
			if ($callCount > 1) {
				
				$tester->fail('callback called with force reload set to false');
			}
			
			$tester->assertEquals($startParams, $params);
			return new ReportData(array(), 0);
		}, $startParams);
		
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		
		$datasource = new CallbackDatasource(function($params) use ($startParams, $tester, $filters){
			
			$tester->assertEquals(array_replace($startParams, $filters), $params);
			return new ReportData(array(), 0);
		}, $startParams);
		
		$datasource->setFilters(new ArrayFilterCollection($filters));
		
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
	}
		
	public function testGetDataWithNamedParamsInCallback(){	
		
		$startParams = array('hello' => 'goodbye');
		$filters = array('thing1' => 'thing2');
		$tester = $this;
		
		$datasource = new CallbackDatasource(function($params, $hello, $thing1 = 'thing3', $thing4 = 'thing5') use ($startParams, $tester, $filters){
			
			$tester->assertEquals('goodbye', $hello);
			$tester->assertEquals('thing2', $thing1);
			$tester->assertEquals('thing5', $thing4);
			$tester->assertEquals(array_replace($startParams, $filters), $params);
			return new ReportData(array(), 0);
		}, $startParams);
		
		$datasource->setFilters(new ArrayFilterCollection($filters));
		
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		
		$datasource = new CallbackDatasource(function($params, $hello, $thing4) use ($startParams, $tester, $filters){
			
			$tester->assertEquals('goodbye', $hello);
			$tester->assertNull($thing4);
			$tester->assertEquals(array_replace($startParams, $filters), $params);
			return new ReportData(array(), 0);
		}, $startParams);
		
		$datasource->setFilters(new ArrayFilterCollection($filters));
		
		$this->assertInstanceOf('Yjv\\Bundle\\ReportRenderingBundle\\ReportData\\DataInterface', $datasource->getData());
		
		$datasource = new CallbackDatasource(function($params, $hello, ReportData $thing4) use ($startParams, $tester, $filters){
			
			$tester->assertEquals('goodbye', $hello);
			$tester->assertNull($thing4);
			$tester->assertEquals(array_replace($startParams, $filters), $params);
			return new ReportData(array(), 0);
		}, $startParams);
		
		$datasource->setFilters(new ArrayFilterCollection($filters));
		
		try {
			
			$datasource->getData();
			$this->fail('failed to throw an exception on no valid input available');
		} catch (\InvalidArgumentException $e) {
		}
	}
	
	public function testSetFilters() {
		
		$tester = $this;
		$filters = array('hello' => 'goodbye');
		
		$datasource = new CallbackDatasource(function($params) use ($tester, $filters){
			
			$tester->assertEquals($filters, $params);
			
			return new ReportData(array(), 0);
		});
		
		
		$datasource->setFilters(new ArrayFilterCollection($filters));
		$datasource->getData();
	}
}

class CallbackClass{
	
	static function callCallback($params) {
		
		return new ReportData(array(), 0);
	}
}

function callback($params) {
	
	return new ReportData(array(), 0);
}

function callbackWithArray(){
	
	return array(array('1'), array('2'), array('3'));
}
