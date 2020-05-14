<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media\Storage;

use Domain\Entity\Users\User as UserModel;
use Xpto\Factory\Medias\Media\Vimeo as VimeoMediaFactory;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Vimeo\Vimeo as VimeoDriver;

/**
 * Vimeo Service Provider
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Vimeo implements ServiceProviderInterface
{
    /**
     * @const string
     */
    const MEDIA_VIMEO = 'media.vimeo';

    /**
     * @const string
     */
    const MEDIA_STORAGE_VIMEO = 'media.storage.vimeo';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param Application $app
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $config = $app['config']['vimeo'];

        $app[self::MEDIA_VIMEO] = $this;

        $app[self::MEDIA_STORAGE_VIMEO] = new VimeoDriver(
            $config['client_id'],
            $config['client_secret'],
            $config['access_token']
        );
    }

    /**
     * @param Application $app
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * @param Request $request
     * @param UserModel $user
     * @param VimeoDriver $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(Request $request, UserModel $user, $service)
    {
        /* @var $media \Xpto\Entity\Medias\Media */
        $media = VimeoMediaFactory::create($user, $request, $service);

        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }
}
