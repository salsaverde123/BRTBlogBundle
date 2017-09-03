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


Step 6: Update your Security config
------

Update your security firewalls and encoders to allow access to users

```yml

# app/config/security.yml

security:

    encoders:
        # ... add encoder to user entity of blog-bundle
        BRT\BlogBundle\Entity\User:
            algorithm: bcrypt
            
    providers:
         # ... add new user provider
        brt_blog_user_db:
            entity: { class: BRT\BlogBundle\Entity\User, property: username }
            
            
    firewalls:
        # ... config the firewall. Put in the top of firewalls 
        brt_blog_firewall:
            anonymous: ~
            form_login:
                login_path: brt_blog_login
                check_path: brt_blog_login
                default_target_path: brt_blog_adminpage
    
    access_control:
        # ... add access control rules
        - { path: ^/blog/default/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/blog/admin, roles: ROLE_ADMIN }
        


```


Step 7: Create admin user
------

Create first user to initialize the blog project

```console

php bin/console doctrine:schema:update --force
```