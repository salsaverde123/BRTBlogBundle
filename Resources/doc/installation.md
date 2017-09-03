Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require brt/blog-bundle
```

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new \BRT\BlogBundle\BRTBlogBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Enable the Routing
------
To access to admin page routing we implement the next code to your routing config

```yml

# app/config/routing.yml

brt_blog:
    resource: "@BRTBlogBundle/Resources/config/routing.yml"
    prefix:   /blog     # You can replace whathever you want


```


Step 4: Install Assets
------

Install all files what the bundle needs to work.

```console

php bin/console assets:install

```


Step 5: Update your Schema
------

Update the database schema to install the require tables.

```console

php bin/console doctrine:schema:update --force

```



Step 6: Create admin user
------

Create first user to initialize the blog project

```console

php bin/console doctrine:schema:update --force
```