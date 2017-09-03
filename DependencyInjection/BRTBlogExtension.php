<?php

namespace BRT\BlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class BRTBlogExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * Lo usaremos para configurar los bundles de los que depende brt blog bundle.
     *
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if(!isset($bundles['VichUploaderBundle'])){
            throw new \Exception("El bundle Vich Uploader Bundle no está instalado", 500);
        } else {

            // Configuración de nuestro bundle
            $configs        = $container->getExtensionConfig($this->getAlias());
            $bundle_config  = $this->processConfiguration(new Configuration(), $configs);


            foreach ($container->getExtensions() as $name => $extension) {

                // Configuramos la extensión de vich_uploader
                if($name == "vich_uploader"){

                        $config = array(
                            "db_driver" => "orm",
                            "mappings" => array(
                                "post_image" => [
                                    "uri_prefix"            => $bundle_config['uploader']['posts']['uri_prefix'],
                                    "upload_destination"    => $bundle_config['uploader']['posts']['upload_destination'],
                                    "namer"                 => "vich_uploader.namer_uniqid"
                                ]
                            )
                        );

                        $container->prependExtensionConfig($name, $config);
                }

            }

        }

    }
}
