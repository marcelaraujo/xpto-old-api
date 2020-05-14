<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Youtube as YoutubeControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media\Storage\Youtube as MediaService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Youtube implements YoutubeControllerInterface
{
    /**
     * Create an youtube media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.youtube.pre-create');

        $app['media'] = $app[MediaService::MEDIA_YOUTUBE]->create(
            $request,
            $app['user'],
            $app[MediaService::MEDIA_STORAGE_YOUTUBE]
        );

        $app['dispatcher']->dispatch('media.youtube.create');

        return new View($app['media'], View::HTTP_CREATED);
    }
}
