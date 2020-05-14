<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias;

use Domain\Entity\Medias\Album as AlbumModel;
use Domain\Entity\Medias\Media as MediaModel;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Medias\Album as AlbumServiceInterface;
use Domain\Service\Users\User as UserServiceInterface;
use Domain\Value\AlbumType;
use Xpto\Factory\Medias\Album as AlbumFactory;
use Xpto\Repository\Medias\Album as AlbumRepository;
use Xpto\Repository\Medias\Media as MediaRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Album implements AlbumServiceInterface
{
    /**
     * @const string
     */
    const MEDIA_ALBUM = 'media.album';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Default albums
     *
     * @var []
     */
    private $defaults = [
        'medias' => AlbumType::COMMON,
        'covers' => AlbumType::COVER,
        'profiles' => AlbumType::PROFILE
    ];

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::MEDIA_ALBUM] = $this;
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
     * Save an album
     *
     * @param  AlbumModel $album
     * @param  MediaModel $media
     * @return AlbumModel
     */
    public function save(AlbumModel $album, MediaModel $media = null)
    {
        if ($media) {
            $album->addMedia($media);
        }

        $this->em->persist($album);
        $this->em->flush();

        return $album;
    }

    /**
     * Remove album
     *
     * @param  AlbumModel $album
     * @return boolean
     */
    public function delete(AlbumModel $album)
    {
        if ($album->isDeleted()) {
            throw new InvalidArgumentException('This album is already deleted');
        }

        if (in_array($album->getType(), $this->defaults)) {
            $message = sprintf('Album %s cannot be deleted', $this->defaults[$album->getType()]);

            throw new InvalidArgumentException($message, 500);
        }

        $album->setStatus(AlbumModel::DELETED);

        $this->em->persist($album);
        $this->em->flush();

        return true;
    }

    /**
     * @param int $mediaId
     * @param int $albumId
     * @param UserModel $user
     * @return bool
     */
    public function insertMedia($mediaId, $albumId, UserModel $user)
    {
        /* @var $media \Xpto\Entity\Medias\Media */
        $media = (new MediaRepository($this->em))->findOneByIdAndUser($mediaId, $user);

        /* @var $album \Xpto\Entity\Medias\Album */
        $album = (new AlbumRepository($this->em))->findOneByIdAndUser($albumId, $user);

        return $this->save($album, $media);
    }

    /**
     * Remove media from an album
     *
     * @param  AlbumModel $album
     * @param  MediaModel $media
     * @return AlbumModel
     */
    public function removeMedia($mediaId, $albumId, UserModel $user)
    {
        /* @var $media \Xpto\Entity\Medias\Media */
        $media = (new MediaRepository($this->em))->findOneByIdAndUser($mediaId, $user);

        /* @var $album \Xpto\Entity\Medias\Album */
        $album = (new AlbumRepository($this->em))->findOneByIdAndUser($albumId, $user);

        $album->removeMedia($media);

        return $this->save($album);
    }

    /**
     * Create the default albums for user
     *
     * @param  UserModel $user
     * @return AlbumModel[]
     */
    public function createDefaultForUser(UserModel $user)
    {
        $albums = [];

        foreach ($this->defaults as $description => $type) {
            $albumDefault = new \Xpto\Entity\Medias\Album();
            $albumDefault->setCover(0);
            $albumDefault->setTitle(sprintf('Album %s of %s', $description, $user->getName()));
            $albumDefault->setType($type);
            $albumDefault->setUser($user);
            $albumDefault->setStatus(AlbumModel::ACTIVE);

            $this->em->persist($albumDefault);

            $albums[] = $albumDefault;
        }

        $this->em->flush();

        return $albums;
    }

    /**
     * List all albums from an user
     *
     * @param UserModel $user
     * @return AlbumModel[]
     */
    public function listByUser(UserModel $user)
    {
        $repository = new AlbumRepository($this->em);

        $albums = $repository->findByUser($user);

        return $albums;
    }

    /**
     * List all albums from an user
     *
     * @param int $userId
     * @param UserServiceInterface $userService
     * @return AlbumModel[]
     */
    public function findAllByUserId($userId, UserServiceInterface $userService)
    {
        $user = $userService->findByUserId($userId);

        $repository = new AlbumRepository($this->em);
        $albums = $repository->findByUser($user);

        return $albums;
    }

    /**
     * List all albums from an user
     *
     * @param string $nickname
     * @param UserServiceInterface $userService
     * @return AlbumModel[]
     */
    public function findAllByNickname($nickname, UserServiceInterface $userService)
    {
        $user = $userService->findByNickname($nickname);

        $repository = new AlbumRepository($this->em);
        $albums = $repository->findByUser($user);

        return $albums;
    }

    /**
     * Open an album to view
     *
     * @param int $id
     * @return AlbumModel
     */
    public function findById($id)
    {
        $repo = new AlbumRepository($this->em);

        $album = $repo->findById($id);

        return $album;
    }

    /**
     * @param UserModel $user
     *
     * @return boolean
     */
    public function createToUser(UserModel $user, Request $request)
    {
        /* @var $album \Xpto\Entity\Medias\Album */
        $album = AlbumFactory::create($request, $user);

        /* @var $service AlbumService */
        return $this->save($album);
    }

    /**
     * Delete an album from an user
     *
     * @param UserModel $user
     * @param $id
     * @return bool
     */
    public function deleteFromUser(UserModel $user, $id)
    {
        $repo = new AlbumRepository($this->em);

        /* @var $album \Xpto\Entity\Medias\Album */
        $album = $repo->findOneByIdAndUser($id, $user);

        /* @var $album \Xpto\Entity\Medias\Album */
        return $this->delete($album);
    }

    /**
     * @param int $id
     * @param UserModel $user
     * @param Request $request
     * @return bool
     */
    public function update($id, UserModel $user, Request $request)
    {
        /* @var $repo AlbumRepository */
        $repo = new AlbumRepository($this->em);

        /* @var $album \Xpto\Entity\Medias\Album */
        $album = $repo->findOneByIdAndUser($id, $user);

        /* @var $album \Xpto\Entity\Medias\Album */
        return $this->save(AlbumFactory::update($album, $request));
    }
}
