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

namespace Instinct\Bundle\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author alexandre.quercia
 * @since v0.0.1
 */
class NewsController extends Controller
{
    /**
     * @since v0.0.1
     *
     * @param integer $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository("InstinctNewsBundle:Article");

        // On r�cup�re le nombre total d'articles
        $nb_articles = $rep->getCount();

        // On d�finit le nombre d'articles par page
        // (pour l'instant en dur dans le contr�leur, mais par la suite on le transformera en param�tre du bundle)
        $nb_articles_page = 1;

        // On calcule le nombre total de pages
        $nb_pages = ceil($nb_articles/$nb_articles_page);

        // On va r�cup�rer les articles � partir du N-i�me article :
        $offset = ($page-1) * $nb_articles_page;

        // Ici on a chang� la condition pour d�clencher une erreur 404
        // lorsque la page est inf�rieur � 1 ou sup�rieur au nombre max.
        if( $page < 1 OR $page > $nb_pages )
        {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }

        $entities = $rep->findBy(
            array(),
            array("date" => "desc"),
        $nb_articles_page,
        $offset);

        return $this->render("InstinctNewsBundle:News:index.html.twig",
            array(
                "entities" => $entities,
                "page"     => $page,
                "page_prev"     => $page-1,
                    "page_next"     => $page+1,
                    "nb_pages" => $nb_pages,
                ));
    }
}