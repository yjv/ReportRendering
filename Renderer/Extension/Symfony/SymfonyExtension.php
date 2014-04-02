<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 4/1/14
 * Time: 10:34 PM
 */

namespace Yjv\ReportRendering\Renderer\Extension\Symfony;


use Symfony\Component\Form\FormFactoryInterface;
use Yjv\ReportRendering\Renderer\Extension\Symfony\Type\Extension\SymfonyFormTypeExtension;
use Yjv\TypeFactory\AbstractExtension;

class SymfonyExtension extends AbstractExtension
{
    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    protected function loadTypeExtensions()
    {
        return array(new SymfonyFormTypeExtension($this->formFactory));
    }

}