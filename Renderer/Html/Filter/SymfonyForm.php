<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/29/14
 * Time: 11:30 PM
 */

namespace Yjv\ReportRendering\Renderer\Html\Filter;


use Symfony\Component\Form\FormInterface as SymfonyFormInterface;

class SymfonyForm implements FormInterface
{
    /** @var  SymfonyFormInterface */
    protected $form;

    public function __construct(SymfonyFormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @param array $filters
     * @return array the filter array processed
     */
    public function processFilters(array $filters)
    {
        foreach ($filters as $name => $value) {

            if ($this->form->has($name)) {

                $child = clone $this->form->get($name);
                $filters[$name] = $child->submit($value)->getData();
            }
        }
        return $filters;
    }

    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param array $filters
     * @return self
     */
    public function setFilters(array $filters)
    {
        $this->form->submit($filters);
        return $this;
    }
}