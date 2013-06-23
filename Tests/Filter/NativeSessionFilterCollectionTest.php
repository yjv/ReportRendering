<?php
namespace Yjv\ReportRendering\Tests\Filter;

use Yjv\ReportRendering\Filter\NativeSessionFilterCollection;

use Yjv\ReportRendering\Filter\SymfonySessionFilterCollection;

use Yjv\ReportRendering\Filter\ArrayFilterCollection;

class NativeSessionFilterCollectionTest extends ArrayFilterCollectionTest
{
	protected $session;
	public $sessionData;
	public $currentReportId;
	
	public function setUp() {
		
		$this->filters = new NativeSessionFilterCollection('other_path');
	}
	
	public function testGettersSetters(){
		
		$this->currentReportId = 'special_report';
		$this->filters->setReportId($this->currentReportId);
		parent::testGettersSetters();
		$this->assertEquals($this->filters->all(), $_SESSION['other_path']['special_report']);

		$this->currentReportId = 'other_special_report';
		$this->filters->setReportId($this->currentReportId);
		parent::testGettersSetters();
		$this->assertEquals($this->filters->all(), $_SESSION['other_path']['special_report']);
	}
}
