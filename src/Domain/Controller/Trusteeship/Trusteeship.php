<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Trusteeship;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trusteeship Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Trusteeship
{
    /**
     * GET Request for /
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request);

    /**
     * PUT request route for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request);

    /**
     * Decline access to a creative
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request);
}
