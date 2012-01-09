Netvlies FormBundle
===================

Deze bundle is een verzameling van alle eigen form elementen
en opmaak.

Installatie
-----------

### 1) Download de bundle

Plaats het volgende in je `deps` bestand en draai `bin/vendors install`:

    [FormBundle]
        git=git@bitbucket.org:netvlies/sf2bundle-form.git
        target=/bundles/Netvlies/Bundle/FormBundle

### 2) Registreer de namespaces

    <?php
    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Netvlies'         => __DIR__.'/../vendor/bundles',
        // ...
    ));

### 3) Activeer de bundle

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
