<?php
namespace Yjv\Bundle\ReportRenderingBundle\Renderer\Csv;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CsvEncoder {

	protected $options = array();
	protected $optionsResolver;
	
	public function __construct(array $options = array()) {
		
		$this->options = $options;
		$this->optionsResolver = new OptionsResolver();
		$this->optionsResolver
			->setRequired(array(
				'delimiter',
				'enclosure',
				'encloseAll',
				'printNull',
				'lineEnding'
			))
			->setDefaults(array(
			
				'delimiter' => ',',
				'enclosure' => '"',
				'encloseAll' => false,
				'printNull' => false,
				'lineEnding' => PHP_EOL
			))
			->setAllowedTypes(array(
				'delimiter' => 'string',
				'enclosure' => 'string',
				'encloseAll' => 'bool',
				'printNull' => 'bool',
				'lineEnding' => 'string'
			))
		;
	}
	
	public function setOption($name, $value) {
		
		$this->options[$name] = $value;
		return $this;
	}
	
	public function getOptions() {
		
		return $this->optionsResolver->resolve($this->options);
	}
	
	public function encode(array $data) {
		
		$options = $this->getOptions();
		
		$output = array();
		foreach ($data as $row) {
			
			$output[] = $this->rowToCsv($row, $options);
		}
		
		return implode($options['lineEnding'], $output);
	}
	
	
	protected function rowToCsv(array $row, array $options) {
	
		$enclosure = $options['enclosure'];
		$delimiter = $options['delimiter'];
		$delimiterEsc = preg_quote($delimiter, '/');
		$enclosureEsc = preg_quote($enclosure, '/');
	
		$output = array();
		foreach ($row as $field) {
			 
			if ($field === null && $options['printNull']) {
				 
				$output[] = 'NULL';
				continue;
			}
	
			//allows objects with __toString functionality to be used here
			$field = (string)$field;
			 
			// Enclose fields containing $delimiter, $enclosure or whitespace
			if ( $options['encloseAll'] || preg_match( "/(?:${delimiterEsc}|${enclosureEsc}|\s)/", $field ) ) {
				 
				$output[] = $enclosure . str_replace($enclosure, '\\' . $enclosure, $field) . $enclosure;
			}else {
				$output[] = $field;
			}
		}
		
		return implode( $delimiter, $output );
	}
	
}
