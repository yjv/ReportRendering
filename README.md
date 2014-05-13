Report Rendering [![Build Status](https://travis-ci.org/yjv/ReportRendering.png?branch=master)](https://travis-ci.org/yjv/ReportRendering)
==============================

[![Total Downloads](https://poser.pugx.org/yjv/report-rendering/downloads.png)](https://packagist.org/packages/yjv/report-rendering)
[![Latest Stable Version](https://poser.pugx.org/yjv/report-rendering/v/stable.png)](https://packagist.org/packages/yjv/report-rendering)

Purpose
-------
Report Rendering is meant to be used to render any tabulatable data from just about any source into just about any format.
This is done by using datasource classes that feed the report and allowing the report to hold multiple renderers
for rendering this data

 Usage
-----

```php
<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/9/14
 * Time: 1:08 AM
 */
require 'vendor/autoload.php';

use Yjv\ReportRendering\ReportRendering;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;

/**
 * set filters posted to this page
 */
session_start();
$filters = new \Yjv\ReportRendering\Filter\NativeSessionFilterCollection();

if (isset($_POST['report_filters'])) {

    foreach ($_POST['report_filters'] as $name => $filterValues) {

        $filters->setReportName($name);
        $filters->replace($filterValues);
    }
}

/**
 * start up a twig environment
 */
$twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
    __DIR__.'/Resources/views/Renderer',
    __DIR__.'/vendor/symfony/twig-bridge/Symfony/Bridge/Twig/Resources/views/Form'
)), array('debug' => true));
/**
 * add the form extension so that the form methods work
 */
$twig->addExtension(new FormExtension(new TwigRenderer(new TwigRendererEngine(array('form_div_layout.html.twig')))));
/**
 * set this extension so the form component's trans calls dont fail
 * if you want to use the symfony translation component
 * you can use the Symfony\Bridge\Twig\ExtensionTranslationExtension class
 */
$twig->addExtension(new \Yjv\ReportRendering\Twig\ReportRenderingExtension());
$twig->addExtension(new Twig_Extension_Debug());
$templating = new TwigEngine($twig, new TemplateNameParser());
$formFactory = Forms::createFormFactory();

/** @var \Yjv\ReportRendering\Report\ReportFactoryInterface $reportFactory */
$reportFactory = \Yjv\ReportRendering\Report\ReportFactoryBuilder::create()
    ->setTemplatingEngine($templating)
    ->setFormFactory($formFactory)
    ->build()
;
$report = $reportFactory->create('report', array(
    'default_renderer' => 'html',
    'filters' => $filters,
    'datasource' => array('array', array(
        'data' => array(
            array('key1' => 'value1', 'key2' => 'value2'),
            array('key1' => 'value3', 'key2' => 'value4'),
        ),
        'filter_map' => array(
            'column1' => '[key1]',
            'column2' => '[key2]',
            0 => '[key1]',
            1 => '[key2]',
        )
    )),
    'renderers' => array(
        'html' => array('html', array(
            'columns' => array(
                array('property_path', array('name' => 'column1', 'path' => '[key1]')),
                array('format_string', array('name' => 'column2', 'format_string' => 'key2 = {[key2]}')),
            ),
            'symfony_form_fields' => array(
                'column1' => array('text', array('property_path' => '[column1]', 'required' => false)),
                'column2' => array('text', array('property_path' => '[column2]', 'required' => false))
            ),
            'javascripts' => array(
                'jquery' => 'http://code.jquery.com/jquery-1.9.1.js',
                'report_rendering' => 'Resources/public/js/html_report.js',
                'bootstrap' => '//netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js'
            ),
            'stylesheets' => array('bootstrap' => '//netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css'),
        )),
        'csv' => array('csv', array(
            'columns' => array(
                array('property_path', array('name' => 'column1', 'path' => '[key1]')),
                array('format_string', array('name' => 'column2', 'format_string' => 'key2 = {[key2]}')),
            )
        ))
    )
));

if (!empty($_GET['csv'])) {

    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachement; filename="report.csv";');
    echo $report->getRenderer('csv')->render()."\n";
    exit;
}
?>
<html>
<body>
<?php echo $report->getRenderer()->render(); ?>
</body>
</html>
```
going to ../index.php will output the html version of the report
and going to ../index.php?csv=1 wii output something like this

```csv
column1, column2
value1, key2 = value2
value3, key2 = value4
```

Core Concepts
-------------

A report is a class that holds a datasource, filter collection and as many renderers as you want.
all datasources must follow the `Yjv\ReportRendering\Datasource\DatasourceInterface` this interface defines general methods for a class that takes filters and returns tabular data.
all filter collections must follow the `Yjv\ReportRendering\Filter\FilterColletctionInterface` this interface defines methods for a class that takes and returns filter values.
all renderers must follow the `Yjv\ReportRendering\Renderer\RendererInterface` this interface defines general methods for renderers that take tabular data and convert it into some reprot format.
when you want to render a report in a certain way you call the report's getRenderer method with the name.
if no name is passed it defaults to that report's default renderer.


Events
------

the report will fire events during the initialization of a renderer

the report will fire events during the loading of data and allow you to change
things both befroe and after the data is loaded.

`report.pre_load_data`

this event is good to use if you want to make some changes before the data is
loaded for example change some some filter values or something like that.
Note: changes to data are ignored.

`report.post_load_data`

this event is good to use for editing data returned form the data source before
it's given to the renderer. Calling setData on the event will replace the data
it has with the data you've supplied.


Factories
---------

even though you could set up the report on your own, configurable
factories make this alot easier by allowing some simple config
changes to make a big difference. Also it supplies reasonable defaults for
alot of things allowing you to only change what you
need and use the rest as is.

there are 4 factories in report rendering
 * ReportFactory
 * RendererFactory
 * ColumnFactory
 * DatasourceFactory

If you know how the symfony2 form factory works this will seem very familiar.

### Types



### Type Extensions

### Extensions



Utilities
---------



About
=====

Requirements
------------

- Any flavor of PHP 5.3 or above should do
- [optional] PHPUnit 3.5+ to execute the test suite (phpunit --version)

Submitting bugs and feature requests
------------------------------------

Bugs and feature request are tracked on [GitHub](https://github.com/yjv/ReportRendering/issues)

Frameworks Integration
----------------------

- [Symfony2](http://symfony.com) pull the [ReportRenderingBundle](https://github.com/yjv/ReportRenderingBundle).

Author
------

Yosef Deray - <joseph.deray@giftcards.com><br />

License
-------

ReportRendering is licensed under the MIT License - see the `LICENSE` file for details