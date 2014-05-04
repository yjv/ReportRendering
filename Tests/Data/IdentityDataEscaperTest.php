<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 5:51 AM
 */

namespace Yjv\ReportRendering\Tests\Data;


use Yjv\ReportRendering\Data\EscapeStrategies;
use Yjv\ReportRendering\Data\IdentityDataEscaper;

class IdentityDataEscaperTest extends \PHPUnit_Framework_TestCase
{
    /** @var  IdentityDataEscaper */
    protected $escaper;

    public function setUp()
    {
        $this->escaper = new IdentityDataEscaper();
    }

    public function testEscape()
    {
        $value = new \stdClass();
        $this->assertSame($value, $this->escaper->escape($value));
    }

    public function testGetSupportedStrategies()
    {
        $this->assertEquals(EscapeStrategies::$allStrategies, $this->escaper->getSupportedStrategies());
    }
}
 