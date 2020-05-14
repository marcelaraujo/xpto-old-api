<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Connections;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Connection Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Connection
{
    /**
     * GET Request for /connection/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /connection/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewById(Application $app, Request $request);

    /**
     * GET request for /connection/{nickname}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewByNickname(Application $app, Request $request);

    /**
     * GET request for /connection/{id}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllById(Application $app, Request $request);

    /**
     * GET request for /connection/{nickname}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @param  string $nickname
     * @return View
     */
    public function viewAllByNickname(Application $app, Request $request);

    /**
     * Create a connection between users
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * Approve request for /approve/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request);

    /**
     * Decline connection request for /decline/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request);

    /**
     * Update a connection
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function put(Application $app, Request $request);

    /**
     * DELETE request route for /connection/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function delete(Application $app, Request $request);
}
