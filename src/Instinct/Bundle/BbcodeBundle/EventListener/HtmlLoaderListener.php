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

namespace Instinct\Bundle\BbcodeBundle\EventListener;

use Instinct\Bundle\FrameworkBundle\EventListener\AbstractHtmlLoaderListener;

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
class HtmlLoaderListener extends AbstractHtmlLoaderListener
{
    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * @since v0.1
     *
     * @param TwigEngine $templating
     */
    public function __construct(TwigEngine $templating)
    {
       $this->templating = $templating;
    }

    /**
     * @since v0.1
     *
     */
    protected function load()
    {
        $js = "\n".str_replace("\n", '', $this->templating->render(
            'InstinctBbcodeBundle:injection:js.html.twig',
            array(
            )
        ))."\n";

        $this->inject($js, self::INJECTION_JS);

        $css = "\n".str_replace("\n", '', $this->templating->render(
            'InstinctBbcodeBundle:injection:css.html.twig',
            array(
            )
        ))."\n";

        $this->inject($css, self::INJECTION_CSS);
    }

}