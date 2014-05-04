<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 5:53 AM
 */

namespace Yjv\ReportRendering\Tests\Data;


use Yjv\ReportRendering\Data\DataEscaperInterface;
use Yjv\ReportRendering\Data\DefaultStrategyDecider;

class DefaultStrategyDeciderTest extends \PHPUnit_Framework_TestCase
{
    /** @var DefaultStrategyDecider */
    protected $decider;

    public function setUp()
    {
        $this->decider = new DefaultStrategyDecider();
    }

    public function testDecide()
    {
        $this->assertEquals(DataEscaperInterface::DEFAULT_STRATEGY, $this->decider->getStrategy('path', 'value'));
    }
}
 