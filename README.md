Netvlies FormBundle
===================

Deze bundle is een verzameling van alle eigen form elementen
en opmaak.

Installatie
-----------
Plaats het volgende in je `deps` bestand en draai `bin/vendors install`:
```
    [FormBundle]
        git=git@bitbucket.org:netvlies/sf2bundle-form.git
        target=/bundles/Netvlies/Bundle/FormBundle
```

Vervolgens registreer je de namespaces:

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Netvlies'         => __DIR__.'/../vendor/bundles',
    // ...
));
```
Activeer de bundle:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Netvlies\Bundle\FormBundle\NetvliesFormBundle(),
    );
    // ...
)
```

