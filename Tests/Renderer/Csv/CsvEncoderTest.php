<?php
namespace Yjv\ReportRendering\Tests\Renderer\Csv;

use Yjv\ReportRendering\Renderer\Csv\CsvEncoder;

class CsvEncoderTest extends \PHPUnit_Framework_TestCase{

	protected $encoder;
	
	public function setUp() {
		
		$this->encoder = new CsvEncoder();
	}
	
	public function testOptions(){
		
		$options = $this->encoder->getOptions();
		
		$encoder = new CsvEncoder(array('lineEnding' => 'r'));
		$this->assertNotEquals($options, $encoder->getOptions());
		
		$this->assertSame($this->encoder, $this->encoder->setOption('lineEnding', 'r'));
		$this->assertEquals($encoder->getOptions(), $this->encoder->getOptions());
		$this->assertNotEquals($options, $this->encoder->getOptions());
	}
	
	/**
     * @dataProvider encodeProvider
     */
    public function testEncode($data, $expectedCsv) {
		
		$this->assertEquals($expectedCsv, $this->encoder->encode($data));
	}
	
	public function encodeProvider() {
		
		return array(
			array(array(
				array('column1', 'column2'),
				array('column1', 'column2')
			), 'column1,column2'.PHP_EOL.'column1,column2'),
			array(array(
				array('column 1', 'column 2'),
				array('column1', 'column2')
			), '"column 1","column 2"'.PHP_EOL.'column1,column2'),
			array(array(
				array('column1', 'column2'),
				array(null, 'column2')
			), 'column1,column2'.PHP_EOL.',column2')
		);
	}
	
	/**
     * @dataProvider encodeWithDifferentOptionsProvider
     */
	public function testEncodeWithDifferentOptions($data, $expectedCsv, $optionName, $optionValue) {
		
		$this->assertEquals($expectedCsv, $this->encoder
				->setOption($optionName, $optionValue)
				->encode($data)
		);
	}

	public function encodeWithDifferentOptionsProvider() {
		
		return array(
			array(array(
				array('column1', 'column2'),
				array('column1', 'column2')
			), 'column1kcolumn2'.PHP_EOL.'column1kcolumn2', 'delimiter', 'k'),
			array(array(
				array('column 1', 'column 2'),
				array('column1', 'column2')
			), 'ecolumn 1e,ecolumn 2e'.PHP_EOL.'column1,column2', 'enclosure', 'e'),
			array(array(
				array('column1', 'column2'),
				array('column1', 'column2')
			), '"column1","column2"'.PHP_EOL.'"column1","column2"', 'encloseAll', true),
			array(array(
				array('column1', 'column2'),
				array(null, 'column2')
			), 'column1,column2'.PHP_EOL.'NULL,column2', 'printNull', true),
			array(array(
				array('column1', 'column2'),
				array('column1', 'column2')
			), 'column1,column2ecolumn1,column2', 'lineEnding', 'e'),
		);
	}
}
