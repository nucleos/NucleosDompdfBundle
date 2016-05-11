What is DompdfBundle?
=============================
[![Latest Stable Version](https://poser.pugx.org/core23/dompdf-bundle/v/stable)](https://packagist.org/packages/core23/dompdf-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/dompdf-bundle/v/unstable)](https://packagist.org/packages/core23/dompdf-bundle)
[![Build Status](http://img.shields.io/travis/core23/DompdfBundle.svg)](http://travis-ci.org/core23/DompdfBundle)
[![Dependency Status](https://www.versioneye.com/php/core23:dompdf-bundle/badge.svg)](https://www.versioneye.com/php/core23:dompdf-bundle)
[![License](http://img.shields.io/packagist/l/core23/dompdf-bundle.svg)](https://packagist.org/packages/core23/dompdf-bundle)



[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/core23)
[![Donate to this project using PayPal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://paypal.me/gripp)

This bundle provides a wrapper for using [dompdf] inside symfony.

### Installation

```
php composer.phar require core23/dompdf-bundle
```

### Enabling the bundle

```php
    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...

            new Core23\DompdfBundle\Core23DompdfBundle(),

            // ...
        );
    }
```

### Usage

Whenever you need to turn a html page into a pdf just use this anywhere in your controller:

```php
// Set some html and get the service
$html = '<h1>Sample Title</h1><p>Lorem Ipsum</p>';
$dompdf = $this->get('dompdf');

// Stream the pdf to the browser
$dompdf->streamHtml($html, "document.pdf");

// Get binary content of the pdf document
$dompdf->getPdf($html);
```

### Configuration

You can configure each dompdf option under the ``config`` key.

```yaml
core23_dompdf:
    defaultOptions:
        dpi: 150
        defaultPaperSize: A4
        ...
```

This bundle is available under the [MIT license](LICENSE.md).

[dompdf]: https://github.com/dompdf/dompdf
