<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias\Album;

use Domain\Entity\Medias\Album\Comment as CommentInterface;
use Silex\ServiceProviderInterface;

/**
 * Comment Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Comment extends ServiceProviderInterface
{
    /**
     * Save a comment
     *
     * @param CommentInterface $comment
     *
     * @return CommentInterface
     */
    public function save(CommentInterface $comment);

    /**
     * Remove a comment
     *
     * @param CommentInterface $comment
     *
     * @return boolean
     */
    public function delete(CommentInterface $comment);
}
