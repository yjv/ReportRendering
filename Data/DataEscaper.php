<?php
namespace Yjv\ReportRendering\Data;

/**
 * @author yosefderay
 *
 */
class DataEscaper implements DataEscaperInterface
{
	public function escape($value, $strategy = DataEscaperInterface::DEFAULT_STRATEGY, $charset = DataEscaperInterface::DEFAULT_CHARSET)
	{
		switch ($strategy) {
	        case 'js':
	            return $this->escapeJs($value, $charset);
	
	        case 'css':
	            return $this->escapeCss($value, $charset);
	
	        case 'html_attr':
	            return $this->escapeHtmlAttr($value, $charset);
	
	        case 'html':
	            return $this->escapeHtml($value, $charset);
	
	        case 'url':
	            return $this->escapeUrl($value, $charset);
	
	        default:
	        	throw new EscapeStrategyNotSupportedException($strategy);
	    }
	}
	
	public function getSupportedStrategies()
	{
		return array(
				'js',
				'css',
				'html_attr',
				'html',
				'url'
		);
	}
	
	public function escapeJs($string, $charset)
	{
        // escape all non-alphanumeric characters
        // into their \xHH or \uHHHH representations
        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, 'UTF-8', $charset);
        }

        if (0 == strlen($string) ? false : (1 == preg_match('/^./su', $string) ? false : true)) {
            throw new EscapingFailedException('The string to escape is not a valid UTF-8 string.');
        }

        $string = preg_replace_callback('#[^a-zA-Z0-9,\._]#Su', array($this, 'escapeJsCallback'), $string);

        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, $charset, 'UTF-8');
        }

        return $string;
	}
	
	public function escapeCss($string, $charset)
	{
        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, 'UTF-8', $charset);
        }

        if (0 == strlen($string) ? false : (1 == preg_match('/^./su', $string) ? false : true)) {
            throw new EscapingFailedException('The string to escape is not a valid UTF-8 string.');
        }

        $string = preg_replace_callback('#[^a-zA-Z0-9]#Su', array($this, 'escapeCssCallback'), $string);

        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, $charset, 'UTF-8');
        }

        return $string;
	}
	
	public function escapeHtmlAttr($string, $charset)
	{
        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, 'UTF-8', $charset);
        }

        if (0 == strlen($string) ? false : (1 == preg_match('/^./su', $string) ? false : true)) {
            throw new EscapingFailedException('The string to escape is not a valid UTF-8 string.');
        }

        $string = preg_replace_callback('#[^a-zA-Z0-9,\.\-_]#Su', array($this, 'escapeHtmlAttrCallback'), $string);

        if ('UTF-8' != $charset) {
            $string = $this->convertEncoding($string, $charset, 'UTF-8');
        }

        return $string;
	}
	
	public function escapeHtml($string, $charset)
	{
        // see http://php.net/htmlspecialchars

        // Using a static variable to avoid initializing the array
        // each time the function is called. Moving the declaration on the
        // top of the function slow downs other escaping strategies.
        static $htmlspecialcharsCharsets;

        if (null === $htmlspecialcharsCharsets) {
            if ('hiphop' === substr(PHP_VERSION, -6)) {
                $htmlspecialcharsCharsets = array('utf-8' => true, 'UTF-8' => true);
            } else {
                $htmlspecialcharsCharsets = array(
                    'ISO-8859-1' => true, 'ISO8859-1' => true,
                    'ISO-8859-15' => true, 'ISO8859-15' => true,
                    'utf-8' => true, 'UTF-8' => true,
                    'CP866' => true, 'IBM866' => true, '866' => true,
                    'CP1251' => true, 'WINDOWS-1251' => true, 'WIN-1251' => true,
                    '1251' => true,
                    'CP1252' => true, 'WINDOWS-1252' => true, '1252' => true,
                    'KOI8-R' => true, 'KOI8-RU' => true, 'KOI8R' => true,
                    'BIG5' => true, '950' => true,
                    'GB2312' => true, '936' => true,
                    'BIG5-HKSCS' => true,
                    'SHIFT_JIS' => true, 'SJIS' => true, '932' => true,
                    'EUC-JP' => true, 'EUCJP' => true,
                    'ISO8859-5' => true, 'ISO-8859-5' => true, 'MACROMAN' => true,
                );
            }
        }

        if (isset($htmlspecialcharsCharsets[$charset])) {
            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
        }

        if (isset($htmlspecialcharsCharsets[strtoupper($charset)])) {
            // cache the lowercase variant for future iterations
            $htmlspecialcharsCharsets[$charset] = true;

            return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, $charset);
        }

        $string = $this->convertEncoding($string, 'UTF-8', $charset);
        $string = htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return $this->convertEncoding($string, $charset, 'UTF-8');
	}
	
	public function escapeUrl($string, $charset)
	{
        // hackish test to avoid version_compare that is much slower, this works unless PHP releases a 5.10.*
        // at that point however PHP 5.2.* support can be removed
        if (PHP_VERSION < '5.3.0') {
            return str_replace('%7E', '~', rawurlencode($string));
        }

        return rawurlencode($string);
	}
	
	protected function escapeJsCallback($matches)
	{
		$char = $matches[0];

        // \xHH
        if (!isset($char[1])) {
            return '\\x'.strtoupper(substr('00'.bin2hex($char), -2));
        }
    
        // \uHHHH
        $char = $this->convertEncoding($char, 'UTF-16BE', 'UTF-8');
    
        return '\\u'.strtoupper(substr('0000'.bin2hex($char), -4));
	}
	
	protected function escapeCssCallback($matches)
	{
        $char = $matches[0];
    
        // \xHH
        if (!isset($char[1])) {
            $hex = ltrim(strtoupper(bin2hex($char)), '0');
            if (0 === strlen($hex)) {
                $hex = '0';
            }
    
            return '\\'.$hex.' ';
        }
    
        // \uHHHH
        $char = $this->convertEncoding($char, 'UTF-16BE', 'UTF-8');
    
        return '\\'.ltrim(strtoupper(bin2hex($char)), '0').' ';
	}
	
	/**
	 * This function is adapted from code coming from Zend Framework.
	 *
	 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
	 * @license   http://framework.zend.com/license/new-bsd New BSD License
	 */
	protected function escapeHtmlAttrCallback($matches)
	{
        /*
         * While HTML supports far more named entities, the lowest common denominator
         * has become HTML5's XML Serialisation which is restricted to the those named
         * entities that XML supports. Using HTML entities would result in this error:
         *     XML Parsing Error: undefined entity
         */
        static $entityMap = array(
            34 => 'quot', /* quotation mark */
            38 => 'amp',  /* ampersand */
            60 => 'lt',   /* less-than sign */
            62 => 'gt',   /* greater-than sign */
        );
    
        $chr = $matches[0];
        $ord = ord($chr);
    
        /**
         * The following replaces characters undefined in HTML with the
         * hex entity for the Unicode replacement character.
         */
        if (($ord <= 0x1f && $chr != "\t" && $chr != "\n" && $chr != "\r") || ($ord >= 0x7f && $ord <= 0x9f)) {
            return '&#xFFFD;';
        }
    
        /**
         * Check if the current character to escape has a name entity we should
         * replace it with while grabbing the hex value of the character.
         */
        if (strlen($chr) == 1) {
            $hex = strtoupper(substr('00'.bin2hex($chr), -2));
        } else {
            $chr = $this->convertEncoding($chr, 'UTF-16BE', 'UTF-8');
            $hex = strtoupper(substr('0000'.bin2hex($chr), -4));
        }
    
        $int = hexdec($hex);
        if (array_key_exists($int, $entityMap)) {
            return sprintf('&%s;', $entityMap[$int]);
        }
    
        /**
         * Per OWASP recommendations, we'll use hex entities for any other
         * characters where a named entity does not exist.
         */
    
        return sprintf('&#x%s;', $hex);
	}
	
	protected function convertEncoding($string, $to, $from)
	{
	    if (function_exists('mb_convert_encoding')) {
	            
	        return mb_convert_encoding($string, $to, $from);
	    } 
	    if (function_exists('iconv')) {

	        return iconv($from, $to, $string);
	    }
	    
        throw new EscapingFailedException('No suitable convert encoding function (use UTF-8 as your encoding or install the iconv or mbstring extension).');
	}
}
