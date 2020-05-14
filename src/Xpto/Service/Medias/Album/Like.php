<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Album;

use Domain\Entity\Medias\Album\Like as LikeModelInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Service\Medias\Album\Like as LikeServiceInterface;
use Xpto\Entity\Medias\Album\Like as LikeModel;
use Xpto\Repository\Medias\Album as AlbumRepository;
use Xpto\Repository\Medias\Album\Like as LikeRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like implements LikeServiceInterface
{
    /**
     * @const string
     */
    const ALBUM_LIKE = 'album.like';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::ALBUM_LIKE] = $this;
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @see \Domain\Service\Albums\Like::save()
     */
    public function save(LikeModelInterface $like)
    {
        $this->em->persist($like);
        $this->em->flush();

        return $like;
    }

    /**
     * @see \Domain\Service\Albums\Like::delete()
     */
    public function delete(LikeModelInterface $like)
    {
        if ($like->isDeleted()) {
            throw new InvalidArgumentException('This like is already deleted.');
        }

        $like->setStatus(LikeModel::DELETED);

        $this->save($like);

        return true;
    }

    /**
     * @see \Domain\Service\Albums\Like::like()
     */
    public function like($album, UserInterface $user, Request $request)
    {
        $album = (new AlbumRepository($this->em))->findById($album);

        $like = new LikeModel();
        $like->setStatus(LikeModelInterface::ACTIVE);
        $like->setUser($user);
        $like->setAlbum($album);
        $like->setAddress($request->getClientIp());
        $like->setAgent($request->headers->get('User-Agent'));

        $this->save($like);

        return true;
    }

    /**
     * @see \Domain\Service\Albums\Like::unlike()
     */
    public function unlike($album, UserInterface $user, Request $request)
    {
        $album = (new AlbumRepository($this->em))->findById($album);

        $like = (new LikeRepository($this->em))->findByAlbumAndUser($album, $user);

        $like->setAddress($request->getClientIp());
        $like->setAgent($request->headers->get('User-Agent'));

        $this->delete($like);

        return true;
    }

    /**
     * @param int $albumId
     */
    public function listLikesFromAlbum($albumId)
    {
        $album = (new AlbumRepository($this->em))->findById($albumId);

        $likes = (new LikeRepository($this->em))->findByAlbum($album);

        return $likes;
    }
}
