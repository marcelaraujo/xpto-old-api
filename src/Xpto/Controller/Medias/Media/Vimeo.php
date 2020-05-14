<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Vimeo as VimeoControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Repository\Medias\Media as MediaRepository;
use Xpto\Service\Medias\Media\Storage\Vimeo as MediaService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Vimeo implements VimeoControllerInterface
{
    /**
     * Create an vimeo media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.vimeo.pre-create');

        $app['media'] = $app[MediaService::MEDIA_VIMEO]->create(
            $request,
            $app['user'],
            $app[MediaService::MEDIA_STORAGE_VIMEO]
        );

        $app['dispatcher']->dispatch('media.vimeo.create');

        return new View($app['media'], View::HTTP_CREATED);
    }
}
