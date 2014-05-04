<?php
namespace Yjv\ReportRendering\DataTransformer;

use Yjv\ReportRendering\Data\DefaultDataEscaper;
use Yjv\ReportRendering\Data\DataEscaperInterface;
use Yjv\ReportRendering\Data\DefaultStrategyDecider;
use Yjv\ReportRendering\Data\IdentityDataEscaper;
use Yjv\ReportRendering\Data\PathStrategyDecider;
use Yjv\ReportRendering\Data\StrategyDeciderInterface;

abstract class AbstractDataTransformer implements DataTransformerInterface
{
    protected $escapeStrategyDecider;
    protected $escaper;

    /**
     * {@inheritdoc}
     */
    public function setEscaper(DataEscaperInterface $escaper)
    {
        $this->escaper = $escaper;
        return $this;
    }

    /**
     * @return DataEscaperInterface
     */
    public function getEscaper()
    {
        if (!$this->escaper) {

            $this->escaper = new IdentityDataEscaper();
        }

        return $this->escaper;
    }

    public function turnOnEscaping()
    {
        $this->setEscaper(new DefaultDataEscaper());
        return $this;
    }

    public function turnOffEscaping()
    {
        $this->setEscaper(new IdentityDataEscaper());
        return $this;
    }

    public function setPathStrategies(array $pathStrategies)
    {
        $this->setEscapeStrategyDecider(new PathStrategyDecider($pathStrategies));
    }

    /**
     * {@inheritdoc}
     */
    public function setEscapeStrategyDecider(StrategyDeciderInterface $decider)
    {
        $this->escapeStrategyDecider = $decider;
        return $this;
    }

    /**
     * @return \Yjv\ReportRendering\Data\DefaultStrategyDecider
     */
    public function getEscapeStrategyDecider()
    {
        if (!$this->escapeStrategyDecider) {

            $this->escapeStrategyDecider = new DefaultStrategyDecider();
        }

        return $this->escapeStrategyDecider;
    }

    protected function escapeValue($path, $value)
    {
        return $this->getEscaper()->escape(
            $value,
            $this->getEscapeStrategyDecider()->getStrategy($path, $value)
        );
    }
}
