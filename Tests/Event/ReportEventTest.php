<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/10/14
 * Time: 11:46 PM
 */

namespace Yjv\ReportRendering\Tests\Event;


use Yjv\ReportRendering\Event\ReportEvent;

class ReportEventTest extends \PHPUnit_Framework_TestCase
{
    protected $report;
    protected $event;

    public function setUp()
    {
        $this->report = \Mockery::mock('Yjv\ReportRendering\Report\ReportInterface');
        $this->event = new ReportEvent($this->report);
    }

    public function testGettersSetters()
    {
        $this->assertSame($this->report, $this->event->getReport());
    }


}
 