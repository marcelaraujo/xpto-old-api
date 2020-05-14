<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Inbox;

use Domain\Controller\Inbox\Inbox as InboxControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Connections\Connection as ConnectionService;
use Xpto\Service\Inbox\Inbox as InboxService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inbox Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Inbox implements InboxControllerInterface
{
    /**
     * List
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app)
    {
        $inboxes = $app[InboxService::INBOX]->listAllByUser($app['user']);

        return new View($inboxes, View::HTTP_OK);
    }

    /**
     * GET request for /Inbox/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $inbox = $app[InboxService::INBOX]->view($request->get('id'), $app['user']);

        return new View($inbox, View::HTTP_OK);
    }

    /**
     * Create an inbox
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('inbox.pre-create');
        $app['inbox'] = $app[InboxService::INBOX]->send($request, $app['user'], $app[ConnectionService::CONNECTION]);
        $app['dispatcher']->dispatch('inbox.create');

        return new View($app['inbox'], View::HTTP_CREATED);
    }

    /**
     * DELETE request route for /Inbox/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('inbox.pre-delete');
        $app['inbox'] = $app[InboxService::INBOX]->removeById($request->get('id'), $app['user']);
        $app['dispatcher']->dispatch('inbox.delete');

        return new View($app['inbox'], View::HTTP_NO_CONTENT);
    }

    /**
     * POST request route for /Inbox/archive/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function archive(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('inbox.pre-archive');
        $app['inbox'] = $app[InboxService::INBOX]->archiveById($request->get('id'), $app['user']);
        $app['dispatcher']->dispatch('inbox.archive');

        return new View($app['inbox'], View::HTTP_NO_CONTENT);
    }
}
