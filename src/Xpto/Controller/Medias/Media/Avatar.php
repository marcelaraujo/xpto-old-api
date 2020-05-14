<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Avatar as AvatarControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Service\Medias\Media\Avatar as AvatarService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * Avatar Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Avatar implements AvatarControllerInterface
{
    /**
     * Create an avatar media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.avatar.pre-create');

        if (!$request->files->has('file')) {
            throw new UploadException('File field not found on request');
        }

        $app['avatar'] = $app[AvatarService::MEDIA_AVATAR]->create(
            $request->files->get('file'),
            $request,
            $app['user'],
            $app['user.profile'],
            $app['media.storage.cloudinary']
        );

        $app['dispatcher']->dispatch('media.avatar.create');

        return new View($app['avatar'], View::HTTP_CREATED);
    }
}
