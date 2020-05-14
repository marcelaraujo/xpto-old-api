<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Signup;

use Domain\Controller\Signup\Signup as SignupControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Signup\Signup as SignupService;
use Xpto\Service\Users\Profile as ProfileService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Signup Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Signup implements SignupControllerInterface
{
    /**
     * Create an user
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function create(Application $app, Request $request)
    {

        $app['profile'] = $app[SignupService::SIGNUP_SIGNUP]->create($request, $app[ProfileService::USER_PROFILE]);

        $app['dispatcher']->dispatch('user.create');

        return new View($app['profile'], View::HTTP_CREATED);
    }
}
