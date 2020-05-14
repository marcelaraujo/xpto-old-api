<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Users;

use Domain\Controller\Users\User as UserControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Users\User as UserService;
use Symfony\Component\HttpFoundation\Request;

/**
 * User Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class User implements UserControllerInterface
{
    /**
     * GET Request for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app)
    {
        $users = $app[UserService::USER_USER]->listAll();

        return new View($users, View::HTTP_OK);
    }

    /**
     * GET request for /user/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewById(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->findByUserId($request->get('id'));

        return new View($user, View::HTTP_OK);
    }

    /**
     * GET request for /user/{nickname}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewByNickname(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->findByNickname($request->get('nickname'));

        return new View($user, View::HTTP_OK);
    }

    /**
     * PUT request route for /user/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function update(Application $app, Request $request)
    {
        $user = $app[UserService::USER_USER]->update($app['user'], $request);

        return new View($user, View::HTTP_NO_CONTENT);
    }

    /**
     * DELETE request route for /user/
     *
     * @param  Application $app
     * @return View
     */
    public function delete(Application $app)
    {
        $user = $app[UserService::USER_USER]->delete($app['user']);

        return new View($user, View::HTTP_NO_CONTENT);
    }
}
