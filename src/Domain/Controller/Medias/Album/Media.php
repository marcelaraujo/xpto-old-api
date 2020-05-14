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
interface Media
{
    /**
     * Insert a media into an album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * DELETE request route for /album/{albumId}/{mediaId}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $albumId
     * @param  int $mediaId
     * @return View
     */
    public function delete(Application $app, Request $request);
}
