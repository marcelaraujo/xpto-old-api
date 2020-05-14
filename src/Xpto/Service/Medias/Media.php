<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias;

use Domain\Entity\Medias\Media as MediaModel;
use Domain\Service\Medias\Media as MediaServiceInterface;
use Xpto\Repository\Medias\Media as MediaRepository;
use Xpto\Factory\Medias\Media as MediaFactory;
use Xpto\Entity\Users\User as UserModel;
use Xpto\Service\Users\User as UserServiceInterface;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Media Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Media implements MediaServiceInterface
{
    /**
     * @const string
     */
    const MEDIA_MEDIA = 'media.media';

    /**
     * @const string
     */
    const MEDIA_CREATE = 'media.create';

    /**
     * @const string
     */
    const MEDIA_DELETE = 'media.delete';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $service = $this;

        $this->em = $app['orm.em'];

        $app[self::MEDIA_MEDIA] = $service;

        $app[self::MEDIA_CREATE] = $app->protect(
            function(MediaModel $media) use ($app, $service) {
                return $service->save($media);
            }
        );

        $app[self::MEDIA_DELETE] = $app->protect(
            function(MediaModel $media) use ($app, $service) {
                return $service->delete($media);
            }
        );
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
     * @param  MediaModel $media
     * @return MediaModel
     */
    public function save(MediaModel $media)
    {
        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }

    /**
     * @param  MediaModel $media
     * @return boolean
     */
    public function delete(MediaModel $media)
    {
        if ($media->isDeleted()) {
            throw new InvalidArgumentException('This media is already deleted.');
        }

        $media->setStatus(MediaModel::DELETED);

        $this->em->persist($media);
        $this->em->flush();

        return true;
    }

    public function listByUser(UserModel $user)
    {
        $repository = new MediaRepository($this->em);
        $medias = $repository->findByUser($user);

        return $medias;
    }

    public function view($id, UserModel $user)
    {
        $repo = new MediaRepository($this->em);

        /* @var $media \Xpto\Entity\Medias\Media */
        $media = $repo->findOneByIdAndUser($id, $user);

        return $media;
    }

    public function update($id, Request $request, UserModel $user)
    {
        $media = $this->view($id, $user);

        $mediaModel = MediaFactory::update($media, $user, $request);

        $this->save($mediaModel);

        return $mediaModel;
    }

    public function remove($id, UserModel $user)
    {
        $media = $this->view($id, $user);

        $this->delete($media);

        return true;
    }

    /**
     * List all albums from an user
     *
     * @param int $userId
     * @param UserServiceInterface $userService
     * @return MediaModel[]
     */
    public function findAllByUserId($userId, UserServiceInterface $userService)
    {
        $user = $userService->findByUserId($userId);

        $repository = new MediaRepository($this->em);
        $albums = $repository->findByUser($user);

        return $albums;
    }

    /**
     * List all albums from an user
     *
     * @param string $nickname
     * @param UserServiceInterface $userService
     * @return MediaModel[]
     */
    public function findAllByNickname($nickname, UserServiceInterface $userService)
    {
        $user = $userService->findByNickname($nickname);

        $repository = new MediaRepository($this->em);
        $albums = $repository->findByUser($user);

        return $albums;
    }
}
