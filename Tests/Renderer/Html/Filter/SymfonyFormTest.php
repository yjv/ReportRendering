<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/30/14
 * Time: 9:25 PM
 */

namespace Yjv\ReportRendering\Tests\Renderer\Html\Filter;


use Mockery\MockInterface;
use Yjv\ReportRendering\Renderer\Html\Filter\SymfonyForm;

class SymfonyFormTest extends \PHPUnit_Framework_TestCase
{
    /** @var SymfonyForm */
    protected $filterForm;
    /** @var MockInterface */
    protected $form;

    public function setUp()
    {
        $this->form = \Mockery::mock('Symfony\Component\FOrm\FormInterface');
        $this->filterForm = new SymfonyForm($this->form);
    }

    public function testGetForm()
    {
        $this->assertSame($this->form, $this->filterForm->getForm());
    }

    public function testSetFilters()
    {
        $filters = array('key' => 'value');
        $this->form
            ->shouldReceive('submit')
            ->once()
            ->with($filters)
        ;
        $this->assertSame($this->filterForm, $this->filterForm->setFilters($filters));
    }

    public function testProcessFilters()
    {
        $filters = array('key' => 'value');
        $returnedFilters = array('key2' => 'value2');
        $this->form
            ->shouldReceive('submit')
            ->once()
            ->with($filters)
            ->andReturn(\Mockery::self())
            ->getMock()
            ->shouldReceive('getData')
            ->once()
            ->andReturn($returnedFilters)
            ->getMock()
        ;
        $this->assertSame($returnedFilters, $this->filterForm->processFilters($filters));
    }
}
 