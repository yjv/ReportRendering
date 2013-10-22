<?php
namespace Yjv\ReportRendering\Tests\Factory\Type\Extension;

use Mockery;

class AbstractTypeExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $typeExtension;
    
    public function setUp()
    {
        $this->typeExtension = Mockery::mock('Yjv\TypeFactory\Type\Extension\AbstractTypeExtension')
            ->shouldDeferMissing()
        ;
    }

    public function testBuild()
    {
        $this->typeExtension->build(Mockery::mock('Yjv\TypeFactory\BuilderInterface'), array());
    }
    
    public function testSetDefaultOptions()
    {
        $resolver = Mockery::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');
        $this->typeExtension->setDefaultOptions($resolver);
    }
}
