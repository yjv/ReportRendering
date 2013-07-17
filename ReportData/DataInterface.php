<?php
namespace Yjv\ReportRendering\ReportData;

/**
 * 
 * @author yosefderay
 *
 */
interface DataInterface extends ImmutableDataInterface
{
    public function setData($data);
    public function setUnpaginatedCount($unpaginatedCount);
}
