<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Album;

use Domain\Controller\Medias\Media\Like as LikeControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Album\Like as LikeAlbumService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like implements LikeControllerInterface
{
    /**
     * Get likes from a album
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $id = $request->get('albumId');

        $result = $app[LikeAlbumService::ALBUM_LIKE]->listLikesFromAlbum($id);

        return new View($result, View::HTTP_OK);
    }

    /**
     * Like a album publication
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $id = $request->get('albumId');

        $result = $app[LikeAlbumService::ALBUM_LIKE]->like($id, $app['user'], $app['request']);

        return new View($result, View::HTTP_CREATED);
    }

    /**
     * Removes like from a publication
     *
     * @param  Application $app
     * @param  Request $request
     * @param  int $id
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $albumId = $request->get('albumId');
        $likeId = $request->get('likeId');

        $result = $app[LikeAlbumService::ALBUM_LIKE]->unlike($albumId, $app['user'], $app['request']);

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
