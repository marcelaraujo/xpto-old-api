<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Connections;

use Domain\Controller\Connections\Connection as ConnectionControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Connections\Connection as ConnectionService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Connection Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Connection implements ConnectionControllerInterface
{
    /**
     * GET Request for /connection/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app)
    {
        $connections = $app[ConnectionService::CONNECTION]->listPendingByUser($app['user']);

        return new View($connections, View::HTTP_OK);
    }

    /**
     * GET request for /connection/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewById(Application $app, Request $request)
    {
        $connection = $app[ConnectionService::CONNECTION]->view($request->get('id'), $app['user']);

        return new View($connection, View::HTTP_OK);
    }

    /**
     * GET request for /connection/{nickname}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewByNickname(Application $app, Request $request)
    {
        $connection = $app[ConnectionService::CONNECTION]->listByNickname($request->get('nickname'));

        return new View($connection, View::HTTP_OK);
    }

    /**
     * GET request for /connection/{id}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllById(Application $app, Request $request)
    {
        $connections = $app[ConnectionService::CONNECTION]->listApprovedByUserId($request->get('id'));

        return new View($connections, View::HTTP_OK);
    }

    /**
     * GET request for /connection/{nickname}/public/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByNickname(Application $app, Request $request)
    {
        $connections = $app[ConnectionService::CONNECTION]->listApprovedByNickname($request->get('nickname'));

        return new View($connections, View::HTTP_OK);
    }

    /**
     * Create a connection between users
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('connection.pre-create');
        $app['connection'] = $app[ConnectionService::CONNECTION]->connect($request, $app['user']);
        $app['dispatcher']->dispatch('connection.create');

        return new View($app['connection'], View::HTTP_CREATED);
    }

    /**
     * Approve request for /approve/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function approve(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('connection.pre-approve');
        $app['connection'] = $app[ConnectionService::CONNECTION]->approve($request->get('id'), $app['user']);
        $app['dispatcher']->dispatch('connection.approve');

        return new View($app['connection'], View::HTTP_NO_CONTENT);
    }

    /**
     * Decline connection request for /decline/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function decline(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('connection.pre-decline');
        $app['connection'] = $app[ConnectionService::CONNECTION]->decline($request->get('id'), $app['user']);
        $app['dispatcher']->dispatch('connection.decline');

        return new View($app['connection'], View::HTTP_NO_CONTENT);
    }

    /**
     * Update a connection
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function put(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('connection.pre-update');
        $app['connection'] = $app[ConnectionService::CONNECTION]->update($request->get('id'), $request, $app['user']);
        $app['dispatcher']->dispatch('connection.update');

        return new View($app['connection'], View::HTTP_NO_CONTENT);
    }

    /**
     * DELETE request route for /connection/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('connection.pre-delete');
        $app['connection'] = $app[ConnectionService::CONNECTION]->remove($request->get('id'), $app['user']);
        $app['dispatcher']->dispatch('connection.delete');

        return new View($app['connection'], View::HTTP_NO_CONTENT);
    }
}
