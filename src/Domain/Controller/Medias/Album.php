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
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Album
{
    /**
     * GET Request for /album/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /album/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request);

    /**
     * Create an album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * Update a album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function put(Application $app, Request $request);

    /**
     * DELETE request route for /album/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);
}
