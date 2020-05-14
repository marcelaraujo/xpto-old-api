<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Comment as CommentControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media\Comment as CommentService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment implements CommentControllerInterface
{
    /**
     * Get liks from a media publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function get(Application $app, Request $request)
    {
        $result = $app[CommentService::MEDIA_COMMENT]->listCommentsFromMedia($request->get('mediaId'));

        return new View($result, View::HTTP_OK);
    }

    /**
     * Comment a media publication
     *
     * @param  Application $app
     * @param  Request $request
     *
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $id = $request->get('mediaId');
        $comment = $request->get('comment');

        $result = $app[CommentService::MEDIA_COMMENT]->comment($id, $comment, $app['user'], $app['request']);

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
        $id = $request->get('mediaId');

        $result = $app[CommentService::MEDIA_COMMENT]->uncomment($id, $app['user'], $app['request']);

        return new View($result, View::HTTP_NO_CONTENT);
    }
}
