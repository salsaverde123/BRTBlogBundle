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

            new BRT\BlogBundle\BRTBlogBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle()
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
    prefix:   /blog     # You can replace whathever you want for private routes
    
brt_blog_public:
    resource: '@BRTBlogBundle/Resources/config/routing_public.yml'
    prefix: '/noticias' # You can replace whathever you want for blog public routes



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

Create first user to initialize the blog project:

default_user: admin

default_password: 123456

```console

php bin/console brt:blogbundle:new-admin

```


Step 7: Add configuration
-----

Add configuration to your config.yml

```yml

    # app/config/config.yml
    
    ...
    
    brt_blog:
        uploader:
            posts:
                uri_prefix: 'http://localhost/your_proyect/web/images/posts'
                upload_destination: '%kernel.root_dir%/../web/images/posts'

```


Step 8: Protect the access:
-----

Add configuration to your security.yml to provide your application with some acces rules. BrtBlogBundle provide an user table 
that you can use to protect your application. 

```yml

    # app/config/security.yml
    
    ...
    
    encoders:
        ...
        
        BRT\BlogBundle\Entity\User: 
            algorithm: bcrypt
    
    providers:
        ...
        
        brt_blog_user_db:
            entity: 
                class: BRT\BlogBundle\Entity\User
                property: username
                
    firewalls:
        ...
        
        brt_blog_firewall:
            pattern: ^/
            anonymous: ~
            provider: brt_blog_user_db
            form_login: 
                login_path: brt_blog_login
                check_path: brt_blog_login
                default_target_path: brt_blog_adminpage
    
    access_control:
        - { path: ^/blog/admin, roles: ROLE_ADMIN }
        - { path: ^/blog/default/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }

```