<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Controller\Notifications;

use Xpto\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notification Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Notification
{
    /**
     * GET Request for /notification/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request);

    /**
     * GET request for /notification/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request);
}
