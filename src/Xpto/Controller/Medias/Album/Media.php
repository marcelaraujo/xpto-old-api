<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Album;

use Domain\Controller\Medias\Album\Media as MediaControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Album as AlbumService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Media implements MediaControllerInterface
{
    /**
     * Insert a media into an album
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $user    = $app['user'];
        $albumId = $request->get('albumId');
        $mediaId = $request->get('mediaId');
        $result  = $app[AlbumService::MEDIA_ALBUM]->insertMedia($mediaId, $albumId, $user);

        return new View($result, View::HTTP_CREATED);
    }

    /**
     * DELETE request route for /album/{albumId}/{mediaId}
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $albumId
     * @param  int $mediaId
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $user    = $app['user'];
        $albumId = $request->get('albumId');
        $mediaId = $request->get('mediaId');
        $result  = $app[AlbumService::MEDIA_ALBUM]->removeMedia($mediaId, $albumId, $user);

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
