<?php
namespace Yjv\ReportRendering\Renderer\Grid\Column\Extension\Core\Type;

use Symfony\Component\OptionsResolver\Options;

use Yjv\ReportRendering\Data\DefaultDataEscaper;
use Yjv\ReportRendering\Data\PathStrategyDecider;
use Yjv\ReportRendering\DataTransformer\FormatStringTransformer;
use Yjv\ReportRendering\Renderer\Grid\Column\ColumnBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Yjv\ReportRendering\Renderer\Grid\Column\AbstractColumnType;

class FormatStringType extends AbstractColumnType
{
    public function getName()
    {
        return 'format_string';
    }

    public function buildColumn(ColumnBuilderInterface $builder, array $options)
    {
        $dataTransformer = new FormatStringTransformer(
            $options['format_string'],
            $options['required'],
            $options['empty_value']
        );

        if ($options['escape_values']) {

            $dataTransformer->turnOnEscaping();
            $dataTransformer->setPathStrategies($options['escape_strategies']);
        }

        $builder->appendDataTransformer($dataTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver
            ->setRequired(array('format_string'))
            ->setDefaults(array(
                'required' => true, 
                'empty_value' => '',
                'escape_values' => true,
                'escape_strategies' => array()
            ))
            ->setAllowedTypes(array(
                'format_string' => 'string', 
                'required' => 'bool', 
                'empty_value' => 'string',
                'escape_values' => 'bool',
                'escape_strategies' => 'array'
            ))
        ;
    }
}
