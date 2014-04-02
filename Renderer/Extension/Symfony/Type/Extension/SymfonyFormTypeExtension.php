<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/30/14
 * Time: 8:57 PM
 */

namespace Yjv\ReportRendering\Renderer\Extension\Symfony\Type\Extension;


use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Html\Filter\SymfonyForm;
use Yjv\ReportRendering\Util\Factory;
use Yjv\TypeFactory\Type\Extension\AbstractTypeExtension;

class SymfonyFormTypeExtension extends AbstractTypeExtension
{
    /** @var FormFactoryInterface  */
    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $typeExtension = $this;

        $resolver
            ->setDefaults(array(
                'filter_form' => function(Options $options)
                {
                    if(!$options['symfony_form']) {

                        return null;
                    }

                    return new SymfonyForm($options['symfony_form']);
                },
                'symfony_form' => function (Options $options) use ($typeExtension)
                {
                    //@codeCoverageIgnoreStart
                    return $typeExtension->buildFilterForm($options);
                    //@codeCoverageIgnoreEnd
                },
                'symfony_form_fields' => array(),
                'symfony_form_options' => array()
            ))
            ->setAllowedTypes(array(
                'symfony_form' => array(
                    'null',
                    'Symfony\Component\Form\FormInterface'
                ),
                'symfony_form_fields' => 'array',
                'symfony_form_options' => 'array'
            ))
            ->setNormalizers(array(
                'symfony_form_fields' => function (Options $options, $filterFields)
                {
                    //@codeCoverageIgnoreStart
                    return Factory::normalizeCollectionToFactoryArguments($filterFields);
                    //@codeCoverageIgnoreEnd
                }
            ));

    }
    public function getExtendedType()
    {
        return 'html';
    }

    public function buildFilterForm(Options $options)
    {
        if (empty($options['symfony_form_fields'])) {

            return null;
        }

        $builder = $this->formFactory->createBuilder('form', null, $options['symfony_form_options']);

        foreach ($options['symfony_form_fields'] as $name => $fieldOptions) {

            $builder->add($name, $fieldOptions[0], $fieldOptions[1]);
        }

        return $builder->getForm();
    }

}