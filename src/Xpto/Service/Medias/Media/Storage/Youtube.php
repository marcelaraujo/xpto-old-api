<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media\Storage;

use Domain\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media\Youtube as YoutubeMediaFactory;
use Madcoda\Youtube\Youtube as YoutubeDriver;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Youtube Service Provider
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Youtube implements ServiceProviderInterface
{
    /**
     * @const string
     */
    const MEDIA_YOUTUBE = 'media.youtube';
    /**
     * @const string
     */
    const MEDIA_STORAGE_YOUTUBE = 'media.storage.youtube';

    /**
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $config = $app['config']['youtube'];

        $app[self::MEDIA_YOUTUBE] = $this;

        $app[self::MEDIA_STORAGE_YOUTUBE] = new YoutubeDriver(['key' => $config['api_key']]);
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param Request $request
     * @param UserModel $user
     * @param YoutubeDriver $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(Request $request, UserModel $user, $service)
    {
        /* @var $media \Xpto\Entity\Medias\Media */
        $media = YoutubeMediaFactory::create($user, $request, $service);

        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }
}
