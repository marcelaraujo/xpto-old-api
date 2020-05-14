<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media\Storage;

use Domain\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media\SoundCloud as SoundCloudMediaFactory;
use Njasm\Soundcloud\SoundcloudFacade;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * SoundCloud Service Provider
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class SoundCloud implements ServiceProviderInterface
{
    /**
     * @const string
     */
    const MEDIA_SOUNDCLOUD = 'media.soundcloud';

    /**
     * @const string
     */
    const MEDIA_STORAGE_SOUNDCLOUD = 'media.storage.soundcloud';

    /**
     * @param Application $app
     *
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $config = $app['config']['soundcloud'];

        $app[self::MEDIA_SOUNDCLOUD] = $this;

        $app[self::MEDIA_STORAGE_SOUNDCLOUD] = new SoundcloudFacade($config['client_id'], $config['client_secret']);
    }

    /**
     * @param Application $app
     *
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param Request $request
     * @param UserModel $user
     * @param SoundcloudFacade $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(Request $request, UserModel $user, $service)
    {
        /* @var $media \Xpto\Entity\Medias\Media */
        $media = SoundCloudMediaFactory::create($user, $request, $service);

        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }
}
