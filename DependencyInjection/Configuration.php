<?php

namespace BRT\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('brt_blog');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->arrayNode("uploader")
                    ->children()
                        // Post configuration
                        ->arrayNode("posts")
                            ->children()
                                ->scalarNode("uri_prefix")->end() // Uri prefix
                                ->scalarNode("upload_destination")->end() // Upload destination
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('paginator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('page_range')
                        ->defaultValue('5')
                        ->end()
                        ->arrayNode('default_options')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('page_name')
                                ->defaultValue('page')
                                ->end()
                                ->scalarNode('sort_field_name')
                                ->defaultValue('sort')
                                ->end()
                                ->scalarNode('sort_direction_name')
                                ->defaultValue('direction')
                                ->end()
                                ->scalarNode('distinct')
                                ->defaultValue(true)
                                ->end()
                                ->scalarNode('filter_field_name')
                                ->defaultValue('filterField')
                                ->end()
                                ->scalarNode('filter_value_name')
                                ->defaultValue('filterValue')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('pagination')
                                ->defaultValue('@KnpPaginator/Pagination/sliding.html.twig')
                                ->end()
                                ->scalarNode('sortable')
                                ->defaultValue('@KnpPaginator/Pagination/sortable_link.html.twig')
                                ->end()
                                ->scalarNode('filtration')
                                ->defaultValue('@KnpPaginator/Pagination/filtration.html.twig')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('views')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('list_template')
                        ->defaultValue('@BRTBlog/Resources/Views/Blog/list_entries.html.twig')
                        ->end()
                        ->scalarNode('show_template')
                        ->defaultValue('@BRTBlog/Resources/Views/Blog/show_entries.html.twig')
                        ->end()
                        ->scalarNode('pagination_template')
                        ->defaultValue('@BRTBlog/Resources/Views/Templates/pagination.html.twig')
                        ->end()
                    ->end()
                ->end()

        ;

        return $treeBuilder;
    }
}
