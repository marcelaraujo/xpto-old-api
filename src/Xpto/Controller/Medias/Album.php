<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias;

use Domain\Controller\Medias\Album as AlbumControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Album as AlbumService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Album implements AlbumControllerInterface
{
    /**
     * GET Request for /album/
     *
     * @param  Application $app
     * @return View
     */
    public function get(Application $app)
    {
        $albums = $app[AlbumService::MEDIA_ALBUM]->listByUser($app['user']);

        return new View($albums);
    }

    /**
     * GET request for /album/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $album = $app[AlbumService::MEDIA_ALBUM]->findById($request->get('id'));

        return new View($album);
    }

    /**
     * GET request for /album/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByUserId(Application $app, Request $request)
    {
        $album = $app[AlbumService::MEDIA_ALBUM]->findAllByUserId($request->get('id'), $app['user.user']);

        return new View($album);
    }
    /**
     * GET request for /album/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByNickname(Application $app, Request $request)
    {
        $album = $app[AlbumService::MEDIA_ALBUM]->findAllByNickname($request->get('nickname'), $app['user.user']);

        return new View($album);
    }

    /**
     * Create an album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $album = $app[AlbumService::MEDIA_ALBUM]->createToUser($app['user'], $request);

        return new View($album, View::HTTP_CREATED);
    }

    /**
     * Update a album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function put(Application $app, Request $request)
    {
        $album = $app[AlbumService::MEDIA_ALBUM]->update($request->get('id'), $app['user'], $request);

        return new View($album);
    }

    /**
     * DELETE request route for /album/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $result = $app[AlbumService::MEDIA_ALBUM]->deleteFromUser($app['user'], $request->get('id'));

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
