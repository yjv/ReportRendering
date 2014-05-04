<?php
namespace Yjv\ReportRendering\DataTransformer;

class DateTimeTransformer extends AbstractDataTransformer
{
    protected $format;

    public function __construct($format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    public function transform($data, $originalData)
    {
        $previousException = null;

        if (is_scalar($data)) {

            try {
                $data = new \DateTime(is_numeric($data) ? '@' . $data : $data);
            } catch (\Exception $e) {
                $data = null;
                $previousException = $e;
            }
        }

        if (!$data instanceof \DateTime) {

            throw new \InvalidArgumentException(
                '$data must be an instance of DateTime, a valid date string or an integer timestamp',
                0,
                $previousException
            );
        }

        return $data->format($this->format);
    }
}
