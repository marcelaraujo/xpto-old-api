<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Like as LikeControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media\Like as LikeService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like implements LikeControllerInterface
{
    /**
     * Get likes from a media publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $result = $app[LikeService::MEDIA_LIKE]->listLikesFromMedia($request->get('mediaId'));

        return new View($result, View::HTTP_OK);
    }

    /**
     * Like a media publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $result = $app[LikeService::MEDIA_LIKE]->like($request->get('mediaId'), $app['user'], $app['request']);

        return new View($result, View::HTTP_CREATED);
    }

    /**
     * Removes like from a publication
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $result = $app[LikeService::MEDIA_LIKE]->unlike($request->get('mediaId'), $app['user'], $app['request']);

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
