<?php
namespace Yjv\Bundle\ReprotRenderingBundle\IdGenerator;

use Yjv\Bundle\ReportRenderingBundle\Report\Report;

use Yjv\Bundle\ReportRenderingBundle\IdGenerator\IdGeneratorInterface;

class CallCountIdGenerator implements IdGeneratorInterface {
	
	public function getId(Report $report) {

		static $count = 0;
		$count++;
		return sha1($count);
	}

}
