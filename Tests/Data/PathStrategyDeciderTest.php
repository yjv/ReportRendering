<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 6:06 AM
 */

namespace Yjv\ReportRendering\Tests\Data;


use Yjv\ReportRendering\Data\DataEscaperInterface;
use Yjv\ReportRendering\Data\EscapeStrategies;
use Yjv\ReportRendering\Data\PathStrategyDecider;

class PathStrategyDeciderTest extends \PHPUnit_Framework_TestCase
{
    /** @var PathStrategyDecider  */
    protected $decider;

    public function setUp()
    {
        $this->decider = new PathStrategyDecider(array(
            'path1' => EscapeStrategies::JS,
            'path2' => EscapeStrategies::CSS
        ));
    }

    public function testGetStrategy()
    {
        $this->assertEquals(EscapeStrategies::JS, $this->decider->getStrategy('path1', 'value'));
        $this->assertEquals(EscapeStrategies::CSS, $this->decider->getStrategy('path2', 'value'));
        $this->assertEquals(DataEscaperInterface::DEFAULT_STRATEGY, $this->decider->getStrategy('path3', 'value'));
    }
}
 