DompdfBundle
============
[![Latest Stable Version](https://poser.pugx.org/core23/dompdf-bundle/v/stable)](https://packagist.org/packages/core23/dompdf-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/dompdf-bundle/v/unstable)](https://packagist.org/packages/core23/dompdf-bundle)
[![License](https://poser.pugx.org/core23/dompdf-bundle/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/core23/dompdf-bundle/downloads)](https://packagist.org/packages/core23/dompdf-bundle)
[![Monthly Downloads](https://poser.pugx.org/core23/dompdf-bundle/d/monthly)](https://packagist.org/packages/core23/dompdf-bundle)
[![Daily Downloads](https://poser.pugx.org/core23/dompdf-bundle/d/daily)](https://packagist.org/packages/core23/dompdf-bundle)

[![Build Status](https://travis-ci.org/core23/DompdfBundle.svg)](https://travis-ci.org/core23/DompdfBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/DompdfBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/core23/DompdfBundle)
[![Code Climate](https://codeclimate.com/github/core23/DompdfBundle/badges/gpa.svg)](https://codeclimate.com/github/core23/DompdfBundle)
[![Coverage Status](https://coveralls.io/repos/core23/DompdfBundle/badge.svg)](https://coveralls.io/r/core23/DompdfBundle)

This bundle provides a wrapper for using [dompdf] inside symfony.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require core23/dompdf-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `bundles.php` file of your project:

```php
// config/bundles.php

return [
    Core23\DompdfBundle\Core23DompdfBundle => ['all' => true],
];
```

## Usage

Whenever you need to turn a html page into a PDF just use this anywhere in your controller:

```php
// Set some html and get the service
$html = '<h1>Sample Title</h1><p>Lorem Ipsum</p>';
$dompdf = $this->get('dompdf');

// Get a StreamResponse for your controller to return the pdf to the browser
$response = $dompdf->getStreamResponse($html, "document.pdf");
$response->send();

// Get binary content of the pdf document
$dompdf->getPdf($html);
```

If you use Twig to create the content, make sure to use `renderView()` instead of `render()`.
Otherwise you might get the following HTTP header printed inside your PDF:
> HTTP/1.0 200 OK Cache-Control: no-cache

```php
$html = $this->renderView('my_pdf.html.twig', array(
    // ...
));
$dompdf->getStreamResponse($html, 'document.pdf');
```

### Configure the Bundle

```yaml
# config/packages/core23_dompdf.yml

core23_dompdf:
    defaults:
        dpi: 150
        defaultPaperSize: A4
        ...
```

### Events

The dompdf wrapper dispatches events to convenient get the inner dompdf instance when creating the pdf.
- `dompdf.output` is dispatched in getPdf
- `dompdf.stream` is dispatched in streamHtml

See [Symfony event dispatcher documentation](https://symfony.com/doc/current/event_dispatcher.html) for more info.

## License

This bundle is under the [MIT license](LICENSE.md).

[dompdf]: https://github.com/dompdf/dompdf
