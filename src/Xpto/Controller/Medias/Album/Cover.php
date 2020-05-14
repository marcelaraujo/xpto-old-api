<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Album;

use Domain\Controller\Medias\Album\Cover as CoverControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Symfony\Component\HttpFoundation\Request;
use Xpto\Service\Medias\Album\Cover as CoverService;

/**
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Cover implements CoverControllerInterface
{
    /**
     * Album Controller
     *
     * @param  Application $app
     * @param  Request $request
     * @return Application
     */
    public function get(Application $app, Request $request)
    {
        $albums = $app[CoverService::ALBUM_COVER]->listByUser($app['user']);

        return new View($albums, View::HTTP_OK);
    }
}
