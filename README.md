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

``` js
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
        new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
    );
}
```

## Routing

Add the following section to your routing to be able to reach the controller.

``` yml
// app/config/routing.yml

NetvliesFormBundle:
    resource:   "@NetvliesFormBundle/Controller/"
    type:       annotation
    prefix:     /form
```

## Usage

After installation and configuration, the service can be directly referenced from within your controllers.

```php
<?php
public function indexAction($formId)
{
    $form = $this->get('netvlies.form')->get($formId);

    ...
}
```

Or directly from the view.

```php

{{ show_form(formId) }}

```

## Form submit and success handling

The bundle provides a default success listener which handles default functionality like storing a result and sending a
confirmation email (when enabled through the admin). Of course you can implement your own application specific success
handling by overriding the default listener (netvlies.listener.form.success) or attaching an additional listener.
Whichever option you prefer. The same holds for the submit listener, which handles the form posts.

### Attaching an additional listener

``` yml
// app/config/services.yml

acme.listener.form.success:
    class: Acme\DemoBundle\EventListener\FormSuccessListener
    calls:
      - [ setContainer, [@service_container] ]
    tags:
      - { name: kernel.event_listener, event: form.success }
```

### Overriding the default listener

``` yml
// app/config/services.yml

netvlies.listener.form.success:
    class: Acme\DemoBundle\EventListener\FormSuccessListener
    calls:
      - [ setContainer, [@service_container] ]
    tags:
      - { name: kernel.event_listener, event: form.success }
```
