<?php

namespace Netvlies\Bundle\NetvliesFormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netvlies_form');

        $rootNode
            ->children()
                ->arrayNode('templates')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form')->defaultValue('NetvliesFormBundle:Twig:form_show.html.twig')->end()
                        ->scalarNode('fields')->defaultValue(null)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
