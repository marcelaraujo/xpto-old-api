<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Inbox;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inbox Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Inbox
{
    /**
     * List
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /Inbox/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function view(Application $app, Request $request);

    /**
     * Create an inbox
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request);

    /**
     * DELETE request route for /Inbox/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request);

    /**
     * POST request route for /Inbox/archive/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function archive(Application $app, Request $request);
}
