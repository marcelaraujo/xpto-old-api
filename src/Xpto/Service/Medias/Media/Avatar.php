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
use Domain\Service\Medias\Media\Avatar as AvatarServiceInterface;
use Xpto\Service\Medias\Media\Storage\Cloudinary as StorageServiceInterface;
use Domain\Service\Users\Profile as ProfileServiceInterface;
use Domain\Value\AlbumType;
use Xpto\Factory\Medias\Media\Image as MediaFactory;
use Xpto\Repository\Medias\Album as AlbumRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Avatar Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Avatar implements AvatarServiceInterface
{
    /**
     * @const string
     */
    const MEDIA_AVATAR = 'media.avatar';

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

        $app[self::MEDIA_AVATAR] = $this;
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
     * Find the avatar album from user
     *
     * @param UserModel $user
     * @return \Xpto\Entity\Medias\Album
     */
    public function findAlbumByUser(UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Medias\Album */
        $repo = new AlbumRepository($this->em);

        /* @var $album \Xpto\Entity\Medias\Album */
        $album = $repo->findOneByUserAndType($user, AlbumType::PROFILE);

        return $album;
    }

    /**
     * Create an avatar to user
     *
     * @param UploadedFile $file
     * @param Request $request
     * @param UserModel $user
     * @param ProfileServiceInterface $profileService
     * @param StorageServiceInterface $service
     * @return \Xpto\Entity\Medias\Media
     */
    public function create(
        UploadedFile $file,
        Request $request,
        UserModel $user,
        ProfileServiceInterface $profileService,
        StorageServiceInterface $storageService
    ) {
        $album = $this->findAlbumByUser($user);
        $media = MediaFactory::create($user, $request, $file, $storageService);

        $album->addMedia($media);

        $profile = $profileService->findByUser($user);
        $profile->setPicture($media);

        $profileService->save($profile);

        $this->em->persist($album);
        $this->em->flush();

        return $media;
    }
}
