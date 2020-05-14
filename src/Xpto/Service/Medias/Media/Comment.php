<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Medias\Media;

use Domain\Entity\Medias\Media\Comment as CommentModelInterface;
use Domain\Entity\Users\User as UserInterface;
use Domain\Service\Medias\Media\Comment as CommentServiceInterface;
use Xpto\Entity\Medias\Media\Comment as CommentModel;
use Xpto\Repository\Medias\Media as MediaRepository;
use Xpto\Repository\Medias\Media\Comment as CommentRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Comment Media Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Comment implements CommentServiceInterface
{
    /**
     * @const string
     */
    const MEDIA_COMMENT = 'media.comment';

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

        $app[self::MEDIA_COMMENT] = $this;
    }

    /**
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @see \Domain\Service\Medias\Comment::save()
     */
    public function save(CommentModelInterface $comment)
    {
        $this->em->persist($comment);
        $this->em->flush();

        return $comment;
    }

    /**
     * @see \Domain\Service\Medias\Comment::delete()
     */
    public function delete(CommentModelInterface $comment)
    {
        if ($comment->isDeleted()) {
            throw new InvalidArgumentException('This media is already deleted.');
        }

        $comment->setStatus(CommentModel::DELETED);

        $this->save($comment);

        return true;
    }

    /**
     * @see \Domain\Service\Medias\Comment::comment()
     */
    public function comment($media, $comment, UserInterface $user, Request $request)
    {
        $media = (new MediaRepository($this->em))->findById($media);

        $model = new CommentModel();
        $model->setStatus(CommentModelInterface::ACTIVE);
        $model->setUser($user);
        $model->setMedia($media);
        $model->setAddress($request->getClientIp());
        $model->setAgent($request->headers->get('User-Agent'));
        $model->setContent($comment);

        $this->save($model);

        return true;
    }

    /**
     * @see \Domain\Service\Medias\Comment::uncomment()
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
     * @param int $mediaId
     */
    public function listCommentsFromMedia($mediaId)
    {
        $media = (new MediaRepository($this->em))->findById($mediaId);

        $comments = (new CommentRepository($this->em))->findByMedia($media);

        return $comments;
    }
}
