<?php
namespace Yjv\ReportRendering\Datasource\Extension\Core\Type;

use Yjv\ReportRendering\Datasource\DatasourceBuilder;

use Yjv\ReportRendering\Datasource\AbstractDatasourceType;

use Yjv\ReportRendering\Datasource\DatasourceBuilderInterface;

use Yjv\ReportRendering\Factory\TypeFactoryInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatasourceType extends AbstractDatasourceType
{
    /**
     * 
     */
    public function getName()
    {
        return 'datasource';
    }

    /**
     * @return boolean
     */
    public function getParent()
    {
        return false;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array('constructor' => null))
            ->setAllowedTypes(array('constructor' => array('callable', 'null')))
        ;
    }

    /**
     * @param unknown $builder
     * @param array $options
     */
    public function buildRenderer(DatasourceBuilderInterface $builder, array $options)
    {
        if ($options['constructor']) {
            
            $builder->setConstructor($options['constructor']);
        }
    }

    public function createBuilder(TypeFactoryInterface $factory, array $options)
    {
        $builder = new DatasourceBuilder($factory, $options);
        return $builder;
    }
}
