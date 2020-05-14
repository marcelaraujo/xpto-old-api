<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media;

use Domain\Entity\Medias\Media\Like as LikeModelInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Service\Medias\Media\Like as LikeServiceInterface;
use Xpto\Entity\Medias\Media\Like as LikeModel;
use Xpto\Repository\Medias\Media as MediaRepository;
use Xpto\Repository\Medias\Media\Like as LikeRepository;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

/**
 * Like Media Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Like implements LikeServiceInterface
{
    /**
     * @const string
     */
    const MEDIA_LIKE = 'media.like';

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

        $app[self::MEDIA_LIKE] = $this;
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }
    
    /**
     * @see \Domain\Service\Medias\Media\Like::save()
     */
    public function save(LikeModelInterface $like)
    {
        $this->em->persist($like);
        $this->em->flush();

        return $like;
    }

    /**
     * @see \Domain\Service\Medias\Media\Like::delete()
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
     * @see \Domain\Service\Medias\Media\Like::like()
     */
    public function like($media, UserInterface $user, Request $request)
    {
        $media = (new MediaRepository($this->em))->findById($media);

        $like = new LikeModel();
        $like->setStatus(LikeModelInterface::ACTIVE);
        $like->setUser($user);
        $like->setMedia($media);
        $like->setAddress($request->getClientIp());
        $like->setAgent($request->headers->get('User-Agent'));

        $this->save($like);

        return true;
    }

    /**
     * @see \Domain\Service\Medias\Media\Like::unlike()
     */
    public function unlike($media, UserInterface $user, Request $request)
    {
        $media = (new MediaRepository($this->em))->findById($media);

        $like = (new LikeRepository($this->em))->findByMediaAndUser($media, $user);

        $like->setAddress($request->getClientIp());
        $like->setAgent($request->headers->get('User-Agent'));

        $this->delete($like);

        return true;
    }

    /**
     * @param int $mediaId
     */
    public function listLikesFromMedia($mediaId)
    {
        $media = (new MediaRepository($this->em))->findById($mediaId);

        $likes = (new LikeRepository($this->em))->findByMedia($media);

        return $likes;
    }
}
