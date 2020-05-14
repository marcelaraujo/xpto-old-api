<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Album;

use Domain\Controller\Medias\Album\Comment as CommentControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Album\Comment as CommentAlbumService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment implements CommentControllerInterface
{
    /**
     * Get comments from a album publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $id = $request->get('albumId');

        $result = $app[CommentAlbumService::ALBUM_COMMENT]->listCommentsFromAlbum($id);

        return new View($result, View::HTTP_OK);
    }

    /**
     * Comment a album publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $id = $request->get('albumId');
        $comment = $request->get('comment');

        $result = $app[CommentAlbumService::ALBUM_COMMENT]->comment($id, $comment, $app['user'], $app['request']);

        return new View($result, View::HTTP_CREATED);
    }

    /**
     * Removes comment from a publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function delete(Application $app, Request $request)
    {
        $commentId = $request->get('commentId');

        $result = $app[CommentAlbumService::ALBUM_COMMENT]->uncomment($commentId, $app['user'], $app['request']);

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
