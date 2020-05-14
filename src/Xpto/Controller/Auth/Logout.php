<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Auth;

use Domain\Controller\Auth\Logout as LogoutControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Auth\Logout as LogoutService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Logout Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Logout implements LogoutControllerInterface
{
    /**
     * Delete all active sessions
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $app[LogoutService::AUTH_LOGOUT]($app['user']);

        return new View([], View::HTTP_NO_CONTENT);
    }
}
