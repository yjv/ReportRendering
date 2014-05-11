<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/11/14
 * Time: 2:40 AM
 */

namespace Yjv\ReportRendering\Tests;


use Mockery\Matcher\MatcherAbstract;

class EqualsMatcher extends MatcherAbstract
{
    protected $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
    }

    public function match(&$actual)
    {
        try {

            \PHPUnit_Framework_Assert::assertEquals($this->expected, $actual);
            return true;
        } catch (\PHPUnit_Framework_AssertionFailedError $e) {

            return false;
        }
    }

    /**
     * Return a string representation of this Matcher
     *
     * @return string
     */
    public function __toString()
    {
        return '<EqualsMatcher>';
    }
}