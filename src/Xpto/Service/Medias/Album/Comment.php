<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Album;

use Domain\Entity\Medias\Album\Comment as CommentModelInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Service\Medias\Album\Comment as CommentServiceInterface;
use Xpto\Entity\Medias\Album\Comment as CommentModel;
use Xpto\Repository\Medias\Album as AlbumRepository;
use Xpto\Repository\Medias\Album\Comment as CommentRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment implements CommentServiceInterface
{
    /**
     * @const string
     */
    const ALBUM_COMMENT = 'album.comment';

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

        $app[self::ALBUM_COMMENT] = $this;
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @see \Domain\Service\Albums\Album\Comment::save()
     */
    public function save(CommentModelInterface $comment)
    {
        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    /**
     * @see \Domain\Service\Albums\Album\Comment::delete()
     */
    public function delete(CommentModelInterface $comment)
    {
        if ($comment->isDeleted()) {
            throw new InvalidArgumentException('This album is already deleted.');
        }

        $comment->setStatus(CommentModel::DELETED);

        $this->save($comment);

        return true;
    }

    /**
     * @see \Domain\Service\Albums\Album\Comment::comment()
     */
    public function comment($album, $comment, UserInterface $user, Request $request)
    {
        $album = (new AlbumRepository($this->em))->findById($album);

        $model = new CommentModel();
        $model->setStatus(CommentModelInterface::ACTIVE);
        $model->setUser($user);
        $model->setAlbum($album);
        $model->setAddress($request->getClientIp());
        $model->setAgent($request->headers->get('User-Agent'));
        $model->setContent($comment);

        $this->save($model);

        return true;
    }

    /**
     * @see \Domain\Service\Albums\Album\Comment::uncomment()
     */
    public function uncomment($comment, UserInterface $user, Request $request)
    {
        $repository = new CommentRepository($this->em);

        $comment = $repository->findById($comment);
        $comment = $repository->findByCommentAndUser($comment, $user);

        $this->delete($comment);

        return true;
    }

    /**
     * @param int $albumId
     */
    public function listCommentsFromAlbum($albumId)
    {
        $album = (new AlbumRepository($this->em))->findById($albumId);

        $comments = (new CommentRepository($this->em))->findByAlbum($album);

        return $comments;
    }
}
