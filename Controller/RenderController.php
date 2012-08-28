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

namespace Instinct\Bundle\MenuBundle\Controller;

use Instinct\Bundle\MenuBundle\Entity\EntryRepository;

use Instinct\Bundle\MenuBundle\Entity\Entry;

use Symfony\Component\Routing\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Routing\RouteCollection;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author alexandre.quercia
 * @since v0.0.1
 */
class RenderController extends Controller
{
    /**
     * @since v0.0.1
     *
     * @Template()
     */
    public function indexAction()
    {
        $entries = $this->getEntryRepository()->findAll();
        return array(
            "entries" => $entries,
            );
    }

    /**
     * @since v0.0.1
     *
     * @return RouteCollection
     */
    protected function getRouteCollection()
    {
        return $this->get("router")->getRouteCollection();
    }

    /**
     * @since v0.0.1
     *
     * @return EntryRepository
     */
    protected function getEntryRepository()
    {
        return $this->getDoctrine()->getRepository("InstinctMenuBundle:Entry");
    }
}