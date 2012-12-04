<?php
/**
 * Instinct - Application PHP using Symfony Framework
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

namespace Instinct\Bundle\BbcodeBundle\Templating;

use Instinct\Bundle\BbcodeBundle\Decoda\DecodaManager;

use Symfony\Component\DependencyInjection\ContainerInterface;

use FM\BbcodeBundle\Templating\BbcodeExtension as BaseBbcodeExtension;
use FM\BbcodeBundle\Decoda\Decoda as Decoda;

class BbcodeExtension extends BaseBbcodeExtension
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $extra_filters = $this->container->getParameter('fm_bbcode.config.filters');
        $extra_hooks   = $this->container->getParameter('fm_bbcode.config.hooks');
        $extra_templatePaths = $this->container->getParameter('fm_bbcode.config.templates');
        $this->filter_sets = $this->container->getParameter('fm_bbcode.filter_sets');

        foreach ($extra_filters as $extra_filter) {
            DecodaManager::add_filter($extra_filter['classname'], $extra_filter['class'] );
        }
        foreach ($extra_hooks as $extra_hook) {
            DecodaManager::add_hook($extra_hook['classname'], $extra_hook['class'] );
        }
        foreach ($extra_templatePaths as $extra_path) {
            $path = $extra_path['path'];
            $path = $this->container->get("kernel")->locateResource($path);
            DecodaManager::add_templatePath($path);
        }
    }

    /**
     * @since v0.0.1
     * @see \FM\BbcodeBundle\Templating\BbcodeExtension::filter()
     *
     * @param string $value
     * @param string $filter
     * @throws \Twig_Error_Runtime
     * @return string
     */
    public function filter($value, $filter)
    {
        if (!is_string($value)) {
            throw new \Twig_Error_Runtime('The filter can be applied to strings only.');
        }

        $messages = $this->container->getParameter('fm_bbcode.config.messages');

        if(!empty($messages))
        {
            $messages = $this->container->get("kernel")->locateResource($messages);
            $messages = json_decode(\file_get_contents($messages), true);
        }
        else
        {
            $message = array();
        }

        $code = new Decoda($value,$messages);

        $current_filter = $this->filter_sets[$filter];

        $locale = $current_filter['locale'];
        $xhtml = $current_filter['xhtml'];

        if (empty($locale)) {
            // apply locale from the session
            if ('default' == $this->locale) {
                $code->setLocale($this->container->get('session')->getLocale());
                // apply locale defined in the configuration
            } else {
                // apply locale from the template
                $code->setLocale($this->locale);
            }
        } else {
            $code->setLocale($locale);
        }

        if (true === $xhtml) {
            $code->setXhtml(true);
        }

        $decoda_manager = new DecodaManager($code, $current_filter['filters'], $current_filter['hooks'], $current_filter['whitelist']);

        return $decoda_manager->getResult()->parse();
    }
}
