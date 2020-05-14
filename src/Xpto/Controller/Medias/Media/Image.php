<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Controller\Medias\Media;

use Domain\Controller\Medias\Media\Image as ImageControllerInterface;
use Xpto\Application;
use Xpto\View\Json as View;
use Xpto\Repository\Medias\Media as MediaRepository;
use Xpto\Service\Medias\Media\Image as MediaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * Image Media Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Image implements ImageControllerInterface
{
    /**
     * Create an image media
     *
     * @param  Application $app
     * @param  Request $request
     * @return View
     * @throws UploadException
     */
    public function post(Application $app, Request $request)
    {
        $app['dispatcher']->dispatch('media.image.pre-create');

        if (!$request->files->has('file')) {
            throw new UploadException('File field not found on request');
        }

        $app['media'] = $app[MediaService::MEDIA_IMAGE]->create(
            $request->files->get('file'),
            $request,
            $app['user'],
            $app['media.storage.cloudinary']
        );

        $app['dispatcher']->dispatch('media.image.create');

        return new View($app['media'], View::HTTP_CREATED);
    }
}
