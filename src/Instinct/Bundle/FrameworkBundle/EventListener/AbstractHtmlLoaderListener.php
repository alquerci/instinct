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

namespace Instinct\Bundle\FrameworkBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\HttpKernelInterface;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Symfony\Component\HttpKernel\KernelEvents;

use Symfony\Bundle\TwigBundle\TwigEngine;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author alexandre.quercia
 * @since v0.1
 */
abstract class AbstractHtmlLoaderListener implements EventSubscriberInterface
{
    const INJECTION_CSS = "</head>";
    const INJECTION_JS = "</body>";

    /**
     * @var Response
     */
    private $_response;

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse', 0),
        );
    }

    /**
     * @since v0.1
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $response = $event->getResponse();
        $request = $event->getRequest();

        // do not capture redirects or modify XML HTTP Requests
        if ($request->isXmlHttpRequest()) {
            return;
        }

        if ($response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $request->getRequestFormat()
        ) {
            return;
        }

        $this->_response = $response;

        $this->load();
    }

    /**
     * Use $this->inject method to load html code
     *
     * @since v0.1
     */
    abstract protected function load();

    /**
     * @since v0.1
     *
     * @param string $str What ?
     * @param string $type Where ?
     */
    final protected function inject($str, $type)
    {
        $content = $this->_response->getContent();
        $pos = $this->_strripos($content, $type);

        if (false !== $pos) {
            $content =  $this->_substr($content, 0, $pos)
                        . $str
                        . $this->_substr($content, $pos);
            $this->_response->setContent($content);
        }
    }

    /**
     * Find the position of the last occurrence
     * of a case-insensitive substring in a string
     *
     * @since v0.1
     *
     * @param string $content
     * @param string $search
     * @return number
     */
    private function _strripos($content, $search, $offset = 0)
    {
        if (function_exists('mb_stripos'))
        {
            return mb_strripos($content, $search, $offset);
        }
        else
        {
            return strripos($content, $search, $offset);
        }
    }

    /**
     * Return part of a string
     *
     * @since v0.1
     *
     * @param string $content
     * @param number $pos
     * @return string
     */
    private function _substr($content, $pos, $length = -1)
    {
        if (function_exists('mb_substr'))
        {
            return mb_substr($content, $pos, $length);
        }
        else
        {
            return substr($content, $pos, $length);
        }
    }
}