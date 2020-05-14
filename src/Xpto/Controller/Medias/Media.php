<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias;

use Domain\Controller\Medias\Media as MediaControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media as MediaService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Media implements MediaControllerInterface
{
    /**
     * GET Request for /media/
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $medias = $app[MediaService::MEDIA_MEDIA]->listByUser($app['user']);

        return new View($medias, View::HTTP_OK);
    }

    /**
     * GET request for /media/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function view(Application $app, Request $request)
    {
        $media = $app[MediaService::MEDIA_MEDIA]->view($request->get('id'), $app['user']);

        return new View($media, View::HTTP_OK);
    }

    /**
     * Update a media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function put(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.pre-update');

        $app['media'] = $app[MediaService::MEDIA_MEDIA]->update($request->get('id'), $request, $app['user']);

        $app['dispatcher']->dispatch('media.update');

        return new View($app['media'], View::HTTP_OK);
    }

    /**
     * DELETE request route for /media/{id}
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.pre-delete');

        $app['media'] = $app[MediaService::MEDIA_MEDIA]->remove($request->get('id'), $app['user']);

        $app['dispatcher']->dispatch('media.delete');

        return new View($app['media'], View::HTTP_NO_CONTENT);
    }

    /**
     * GET request for /media/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByUserId(Application $app, Request $request)
    {
        $media = $app[MediaService::MEDIA_MEDIA]->findAllByUserId($request->get('id'), $app['user.user']);

        return new View($media, View::HTTP_OK);
    }

    /**
     * GET request for /media/{id}
     *
     * The {id} parameter must be an integer
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function viewAllByNickname(Application $app, Request $request)
    {
        $media = $app[MediaService::MEDIA_MEDIA]->findAllByNickname($request->get('nickname'), $app['user.user']);

        return new View($media, View::HTTP_OK);
    }
}
