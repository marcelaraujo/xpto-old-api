<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Medias;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Media
{
    /**
     * GET Request for /media/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request);

    /**
     * GET request for /media/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request);

    /**
     * Update a media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function put(Application $app, Request $request);

    /**
     * DELETE request route for /media/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);
}
