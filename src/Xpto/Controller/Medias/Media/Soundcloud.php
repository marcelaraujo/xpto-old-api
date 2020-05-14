<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Soundcloud as SoundCloudControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media\Storage\SoundCloud as MediaService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Soundcloud implements SoundCloudControllerInterface
{
    /**
     * Create a SoundCloud media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.soundcloud.pre-create');

        $app['media'] = $app[MediaService::MEDIA_SOUNDCLOUD]->create(
            $request,
            $app['user'],
            $app[MediaService::MEDIA_STORAGE_SOUNDCLOUD]
        );

        $app['dispatcher']->dispatch('media.soundcloud.create');

        return new View($app['media'], View::HTTP_CREATED);
    }
}
