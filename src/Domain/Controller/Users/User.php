<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Users;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface User
{
    /**
     * GET Request for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app);

    /**
     * GET request for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewById(Application $app, Request $request);

    /**
     * GET request for /user/{nickname}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewByNickname(Application $app, Request $request);

    /**
     * PUT request route for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request);

    /**
     * DELETE request route for /user/
     *
     * @param  Application $app
     * @return View
     */
    public function delete(Application $app);
}
