<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Auth;

use Domain\Controller\Auth\Login as LoginControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Auth\Login as LoginServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Login Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Login implements LoginControllerInterface
{
    /**
     * Login action
     * @param Application $app
     * @param Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $user = $request->get('email');
        $pass = $request->get('password');

        $status = $app[LoginServiceProvider::AUTH_VALIDATE_CREDENTIALS]($user, $pass);

        $token = $app[LoginServiceProvider::AUTH_NEW_TOKEN]($status, $request);

        $result = $status ? [
            'token' => $token,
            'profile' => $app[LoginServiceProvider::AUTH_USER_GET]($token)
        ] : [];

        return new View($result, View::HTTP_CREATED);
    }
}
