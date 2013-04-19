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
 * @copyright Copyright (C) 2013  alexandre.quercia
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @author alexandre.quercia
 */

namespace Instinct\Bundle\StyleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author alexandre.quercia
 * @since v0.1
 */
class HtmlLoaderController extends Controller
{
    /**
     * @since v0.1
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cssAction()
    {
        return $this->render('InstinctStyleBundle:HtmlLoader:css.html.twig');
    }

    /**
     * @since v0.1
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jsAction()
    {
        return $this->render('InstinctStyleBundle:HtmlLoader:js.html.twig');
    }

    public function metaAction()
    {
        $charset = $this->container->getParameter('kernel.charset');

        return $this->render('InstinctStyleBundle:HtmlLoader:meta.html.twig', array(
            'charset' => $charset,
            'content' => array(
            ),
            'http_headers' => array(
                // keep BC with HTML 4.01
                'content-type' => sprintf('text/html; charset=%s', $charset),
            ),
        ));
    }
}
