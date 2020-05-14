<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Notifications;

use Domain\Controller\Notifications\Notification as NotificationControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Notifications\Notification as NotificationService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Notification Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Notification implements NotificationControllerInterface
{
    /**
     * GET Request for /notification/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $notifications = $app[NotificationService::NOTIFICATION]->listByUser($app['user']);

        return new View($notifications, View::HTTP_OK);
    }

    /**
     * GET request for /notification/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $notification = $app[NotificationService::NOTIFICATION]->view($request->get('id'), $app['user']);

        return new View($notification, View::HTTP_OK);
    }
}
