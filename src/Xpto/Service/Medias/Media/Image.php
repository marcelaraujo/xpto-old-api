<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media;

use Domain\Entity\Users\User as UserModel;
use Domain\Entity\Medias\Media as MediaModel;
use Domain\Service\Medias\Media as MediaServiceInterface;
use Xpto\Service\Medias\Media\Storage\Cloudinary as StorageServiceInterface;
use Xpto\Factory\Medias\Media\Image as MediaFactory;
use Silex\Application;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Avatar Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Image implements MediaServiceInterface\Image
{
    /**
     * @const string
     */
    const MEDIA_IMAGE = 'media.image';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Storage service
     *
     * @var \Xpto\Service\Medias\Media\Storage\Cloudinary
     */
    private $storage;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::MEDIA_IMAGE] = $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * Create an image to user
     *
     * @param UploadedFile $file
     * @param Request $request
     * @param UserModel $user
     * @param StorageServiceInterface $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(
        UploadedFile $file,
        Request $request,
        UserModel $user,
        StorageServiceInterface $storageService
    ) {
        $media = MediaFactory::create($user, $request, $file, $storageService);

        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }
}
