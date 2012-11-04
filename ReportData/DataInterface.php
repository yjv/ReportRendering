<?php
namespace Yjv\Bundle\ReportRenderingBundle\ReportData;

/**
 * 
 * @author yosefderay
 *
 */
interface DataInterface extends ImmutableDataInterface{

	public function setData();
	public function setUnfilteredCount();
}
