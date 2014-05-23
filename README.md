Report Rendering [![Build Status](https://travis-ci.org/yjv/ReportRendering.png?branch=master)](https://travis-ci.org/yjv/ReportRendering)
==============================

[![Total Downloads](https://poser.pugx.org/yjv/report-rendering/downloads.png)](https://packagist.org/packages/yjv/report-rendering)
[![Latest Stable Version](https://poser.pugx.org/yjv/report-rendering/v/stable.png)](https://packagist.org/packages/yjv/report-rendering)

Purpose
-------
Report Rendering is meant to be used to render any tabulatable data from just about any source into just about any format.
This is done by using datasource classes that feed the report and allowing the report to hold multiple renderers
for rendering this data. The main idea with this library was to make it as flexible
as possible to be able to accommodate whatever requests you may get with formatting, coloring
or otherwise of a report table, row or cell, whether it is static, per row or data driven.

 Usage
-----

this is an example of a report with 2 renderers having an array datasource.
it uses twig to render the html one and uses the symfony form component for
rendering the filters.

```php
<?php
/**
 * Created by PhpStorm.
 * User: yosefderay
 * Date: 3/9/14
 * Time: 1:08 AM
 */
require 'vendor/autoload.php';

use Yjv\ReportRendering\Filter\NativeSessionFilterCollection;
use Yjv\ReportRendering\Report\ReportInterface;
use Yjv\ReportRendering\ReportRendering;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Yjv\ReportRendering\Twig\ReportRenderingExtension;

/**
 * set filters posted to this page
 */

//uncomment if you have session issues
//session_start();
$filters = new NativeSessionFilterCollection();

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
 * add the form extension so that the form methods work for rendering the form
 */
$twig->addExtension(new FormExtension(new TwigRenderer(new TwigRendererEngine(array('form_div_layout.html.twig')))));
/**
 * set this extension so the form component's trans calls dont fail
 * if you want to use the symfony translation component
 * you can use the Symfony\Bridge\Twig\ExtensionTranslationExtension class
 */
$twig->addExtension(new ReportRenderingExtension());
$twig->addExtension(new Twig_Extension_Debug());
$templating = new TwigEngine($twig, new TemplateNameParser());
$formFactory = Forms::createFormFactory();

/**
 * This is where the actual report creation happens. everything above is basic setup
 * for any application to use twig and forms in twig. other than the first few lines that deal
 * with filters being sent in from the rendered html report
 *
 * @var \Yjv\ReportRendering\Report\ReportFactoryInterface $reportFactory
 */
$reportFactory = ReportRendering::createReportFactoryBuilder()
    ->setTemplatingEngine($templating)
    ->setFormFactory($formFactory)
    ->build()
;
$report = $reportFactory->create('report', array(
    //here you are telling the report factory what filter collection to use
    //in the report
    'filters' => $filters,
    //here you are setting up the data source
    //in this case it is an array data source which takes an array as its data
    //and returns it to the report. filtered by the data in the filters set above
    'datasource' => array('array', array(
        //this is the data the array data source will use to pass the filtered data to the
        //report
        'data' => array(
            array('key1' => 'value1', 'key2' => 'value2'),
            array('key1' => 'value3', 'key2' => 'value4'),
        ),
        //this allows for filters in the filter collection that dont match keys in the
        //array data to be mapped
        'filter_map' => array(
            //this means that if a filter key is 'column1' it will be mapped and used to filter
            //on the '[key1]' property path
            'column1' => '[key1]',
            'column2' => '[key2]',
            0 => '[key1]',
            1 => '[key2]',
        )
    )),
    //here you are setting all the renderers the report will have. in this case
    //we are setting it up with an html renderer as the default renderer and also adding
    //a csv renderer to render the same data in csv format. at the moment the columns need
    //to be set on both renderers as they are built seperately. Plans are to make it possible to
    //set the columns once
    'renderers' => array(
        //this makes this the default renderer used when $report->getRenderer() is
        //called with no arguments
        ReportInterface::DEFAULT_RENDERER_KEY => array('html', array(
            //this sets the columns to use in the html renderer. in this case the first column
            //will be a property_path column and will be named column1 second will be a format_string
            //column and be named column2
            'columns' => array(
                array('property_path', array('name' => 'column1', 'path' => '[key1]')),
                array('format_string', array('name' => 'column2', 'format_string' => 'key2 = {[key2]}')),
            ),
            //this tells the renderer factory to use a symfony form for the filter fields
            //this defines the actual fields to use as the filters
            'symfony_form_fields' => array(
                'column1' => 'text',
                'column2' => 'text'
            ),
            //this tells the renderer that you want to have these javascripts added when rendering
            //the report. This is not necessary and you can add it somewhere else on the page that
            //you render the report on but it's here if it's needed
            'javascripts' => array(
                'jquery' => 'http://code.jquery.com/jquery-1.9.1.js',
                'report_rendering' => 'Resources/public/js/html_report.js',
                'bootstrap' => '//netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js'
            ),
            //this tells the renderer that you want to have these css stylesheets added when rendering
            //the report. This is not necessary and you can add it somewhere else on the page that
            //you render the report on but it's here if it's needed
            'stylesheets' => array('bootstrap' => '//netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css'),
        )),
        //this will make it that the call to $report->getRenderer('csv') will return this renderer
        //the type of it is also csv
        'csv' => array('csv', array(
            //this sets the columns to use in the html renderer. in this case the first column
            //will be a property_path column and will be named column1 second will be a format_string
            //column and be named column2
            'columns' => array(
                array('property_path', array('name' => 'column1', 'path' => '[key1]')),
                array('format_string', array('name' => 'column2', 'format_string' => 'key2 = {[key2]}')),
            )
        ))
    )
));

//if the url has ?csv=1 in it render a csv
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
<!-- if not render the default renderer which is the html renderer -->
<?php echo $report->getRenderer()->render(); ?>
</body>
</html>
```
going to ../index.php will output the html version. something like this.
![Html Screen Shot](/html_screenshot.png?raw=true "Html Screen Shot")
and going to ../index.php?csv=1 wii output something like this as a csv download.

```csv
column1, column2
value1, key2 = value2
value3, key2 = value4
```


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