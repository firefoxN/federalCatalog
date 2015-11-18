<?php

namespace Bundles\Category\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CategoryCoreExtension extends Extension implements PrependExtensionInterface
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
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        //Get all bundles
        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['DoctrineBundle'])) {
            //Get configuration of our bundle
            $configuration = new Configuration();
            $configs = $container->getExtensionConfig($this->getAlias());
            $config = $this->processConfiguration($configuration, $configs);

            //Prepare array for insertions
            $forInsertion = [
                'orm' => [
                    'resolve_target_entities' => [
                        'Bundles\Category\ModelBundle\Model\ProductInterface' => $config['entity']['class'],
                    ],
                ],
            ];

            //Insert our config to doctrine extension config
            $container->prependExtensionConfig('doctrine', $forInsertion);
        }
    }
}
