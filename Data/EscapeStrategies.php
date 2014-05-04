<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 5/4/14
 * Time: 12:43 AM
 */

namespace Yjv\ReportRendering\Data;


class EscapeStrategies 
{
    const JS = 'js';
    const CSS = 'css';
    const HTML_ATTR = 'html_attr';
    const HTML = 'html';
    const URL = 'url';

    public static $allStrategies = array(
        self::JS,
        self::CSS,
        self::HTML_ATTR,
        self::HTML,
        self::URL
    );
} 