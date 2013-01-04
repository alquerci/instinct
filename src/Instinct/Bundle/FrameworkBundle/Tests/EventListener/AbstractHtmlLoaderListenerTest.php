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

namespace Instinct\Bundle\FrameworkBundle\Tests\EventListener;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Instinct\Bundle\FrameworkBundle\EventListener\AbstractHtmlLoaderListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class AbstractHtmlLoaderListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataInsert
     *
     * @since v0.1
     *
     * @param string $value
     * @param string $expected
     */
    public function testInsert($value, $expected)
    {
        $kernel  = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $request = new Request();
        $response = new Response($value);

        $event = new FilterResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, $response);
        $listener = new HtmlLoaderListener();
        $listener->onKernelResponse($event);

        $this->assertSame($expected, $response->getContent());
    }

    /**
     * @since v0.1
     *
     * @return multitype:multitype:string
     */
    public function dataInsert()
    {
        return array(
            array("<html><head>\xF0</head><body>\xF0</body></html>", "<html><head>\xF0<css /></head><body>\xF0<script /></body></html>"),
            array("<html><body>\xF0</body></html>", "<html><body>\xF0<script /></body></html>"),
            array("<html><head>\xF0</head></html>", "<html><head>\xF0<css /></head></html>"),
            array("<html></html>", "<html></html>"),
            );
    }
}

class HtmlLoaderListener extends AbstractHtmlLoaderListener
{
    protected function load()
    {
        $this->inject("<script />", self::INJECTION_JS);
        $this->inject("<css />", self::INJECTION_CSS);
    }
}