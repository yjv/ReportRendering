<?php
namespace Yjv\ReportRendering\Tests\Renderer\Csv;

use Symfony\Component\HttpFoundation\Response;

use Mockery;

use Yjv\ReportRendering\Renderer\Csv\CsvEncoder;

use Yjv\ReportRendering\Renderer\Grid\Column\Column;

use Yjv\ReportRendering\ReportData\ImmutableReportData;

use Yjv\ReportRendering\Renderer\Csv\CsvRenderer;

class CsvRendererTest extends \PHPUnit_Framework_TestCase{

	protected $renderer;
	protected $grid;
	
	public function setUp() {
		
		$this->grid = Mockery::mock('Yjv\ReportRendering\Renderer\Grid\GridInterface');
		$this->renderer = new CsvRenderer($this->grid);
	}
	
	public function testSetData() {
		
	    $data = new ImmutableReportData(array(), 0);
		$this->grid
		    ->shouldReceive('setData')
		    ->once()
		    ->with($data)
		;
		$this->assertSame($this->renderer, $this->renderer->setData($data));
	}
	
	public function testSetReport(){
		
		$this->assertSame($this->renderer, $this->renderer->setReport(Mockery::mock('Yjv\ReportRendering\Report\Report')));
	}
	
	public function testForceReload() {
		
		$this->assertFalse($this->renderer->getForceReload());
		$renderer = new CsvRenderer($this->grid, array(), true);
		
		$this->assertTrue($renderer->getForceReload());
	}
	
	public function testRender() {
		
		$this->setupGridForRender(2);
		
		$expectedCsv = <<<CSV
column1,column2
"column1 data","column2 data"
column1_data,column2_data
CSV;
		
		$this->assertEquals($expectedCsv, $this->renderer->render());
		
		$this->renderer->setCsvOption('delimiter', 'l');
		
		$expectedCsv = <<<CSV
"column1"l"column2"
"column1 data"l"column2 data"
"column1_data"l"column2_data"
CSV;
		
		$this->assertEquals($expectedCsv, $this->renderer->render());
	}
	
	public function testSetCsvOption() {
		
		$this->assertSame($this->renderer, $this->renderer->setCsvOption('delimiter', 'l'));
	}
	
	public function testRenderResponse() {
		
		$this->setupGridForRender(2);
		
		$expectedCsv = <<<CSV
column1,column2
"column1 data","column2 data"
column1_data,column2_data
CSV;
		$filename = 'filename.csv';
		
		$expectedResponse = new Response($expectedCsv, 200, array(

			'Content-Type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename=' . $filename,
			'Pragma' => 'no-cache',
			'Expires' => '0'	
		));
		
		$this->assertEquals($expectedResponse, $this->renderer->renderResponse(array('filename' => $filename)));
		
		$response = $this->renderer->renderResponse();
		
		$this->assertEquals(1, preg_match('/attachment; filename=.*\.csv/', $response->headers->get('Content-Disposition')));
	}
	
	protected function setupGridForRender($expectedCallCount) {
		
		$column1 = new Column();
		$column1->setOptions(array('name' => 'column1'));
		
		$column2 = new Column();
		$column2->setOptions(array('name' => 'column2'));
		
		$this->grid
		    ->shouldReceive('getColumns')
		    ->times($expectedCallCount)
		    ->andReturn(array($column1, $column2))
		;
		
		$rows = array(

				array('cells' => array(

						array('data' => 'column1 data'),
						array('data' => 'column2 data'),
				)),
				array('cells' => array(

						array('data' => 'column1_data'),
						array('data' => 'column2_data'),
				)),
		);
		
		$this->grid
		    ->shouldReceive('getRows')
		    ->times($expectedCallCount)
		    ->andReturn($rows)
		;
	}
}
