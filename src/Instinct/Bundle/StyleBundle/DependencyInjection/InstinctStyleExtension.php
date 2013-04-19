<?php
/**
 * The Instinct PHP framework
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright (C) 2012  alexandre.quercia
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @author alexandre.quercia
 */

namespace Instinct\Bundle\StyleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class InstinctStyleExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['css'])) {
            $this->registerCssConfiguration($config['css'], $container, $loader);
        }

        if (isset($config['js'])) {
            $this->registerJsConfiguration($config['js'], $container, $loader);
        }
    }

    private function registerCssConfiguration($config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('instinct_style.css.overwrite', $config['overwrite']);
        $container->setParameter('instinct_style.css.controllers', $config['controllers']);
    }

    private function registerJsConfiguration($config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('instinct_style.js.overwrite', $config['overwrite']);
        $container->setParameter('instinct_style.js.controllers', $config['controllers']);
    }
}
