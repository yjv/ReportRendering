<?php
namespace Yjv\ReportRendering\Tests\Renderer\Extension\Symfony;



use Mockery;
use Yjv\ReportRendering\Renderer\Extension\Symfony\SymfonyExtension;

class SymfonyExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var SymfonyExtension  */
    protected $extension;
    protected $formFactory;

    public function setUp()
    {
        $this->formFactory = Mockery::mock('Symfony\Component\Form\FormFactoryInterface');
        $this->extension = new SymfonyExtension($this->formFactory);
    }
    
    public function testTypesThereWithoutRenderer()
    {
        $typeExtensions = $this->extension->getTypeExtensions('html');
        $this->assertInstanceOf(
            'Yjv\ReportRendering\Renderer\Extension\Symfony\Type\Extension\SymfonyFormTypeExtension',
            $typeExtensions[0]
        );
    }
}
