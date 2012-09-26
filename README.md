Netvlies FormBundle
===================

The Netvlies FormBundle enables users to create basic forms through the Sonata
Admin Bundle. It includes form configuration, storage of results, sending of
notifications when a form is filled in and even the possibility to export form
results through the Sonata list view.

Forms created using the FormBundle can be retrieved using the form service or
be directly shown by using the show_form function provided by the FormBundle
Twig extension.

## Requirements

* Symfony
* Dependencies:
 * [`PHPExcel`](https://github.com/ddeboer/phpexcel)

## Installation

### Add in your composer.json

This requires the definition of a repository in your composer.json as the bundle
is not publicly available via Packagist.

```js
{
    "require": {
        "netvlies/sf2bundle-form": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "git@bitbucket.org:netvlies/sf2bundle-form.git"
        }
    ],
}
```

### Install the bundle

``` bash
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar update netvlies/sf2bundle-form
```

Composer will install the bundle to your project's `vendor/netvlies` directory.

### Enable the bundle via the kernel

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Netvlies\Bundle\FormBundle\NetvliesFormBundle(),
    );
}
```

## Usage

After installation and configuration, the service can be directly referenced from within your controllers.

```php
<?php
public function indexAction()
{
    $form = $this->get('netvlies_form')->get($formId);

    ...
}
```

Or directly from the view.

```php

{{ show_form(formId) }}

```