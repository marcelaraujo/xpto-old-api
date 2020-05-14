<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Medias\Album;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Cover
{
    /**
     * Album Controller
     *
     * @param  Application $app
     * @param  Request $request
     * @return Application
     */
    public function get(Application $app, Request $request);
}
