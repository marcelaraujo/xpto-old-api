<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias\Media;

use Domain\Entity\Medias\Media\Like as LikeInterface;
use Domain\Entity\Users\User as UserInterface;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Media Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Like extends ServiceProviderInterface
{
    /**
     * Save a like
     *
     * @param LikeInterface $like
     *
     * @return LikeInterface
     */
    public function save(LikeInterface $like);

    /**
     * Remove a like
     *
     * @param LikeInterface $like
     *
     * @return boolean
     */
    public function delete(LikeInterface $like);

    /**
     * Like a media
     *
     * @param int $media
     * @param UserInterface $user
     * @param Request $request
     */
    public function like($media, UserInterface $user, Request $request);

    /**
     * Unlike a media
     *
     * @param int $media
     * @param UserInterface $user
     * @param Request $request
     */
    public function unlike($media, UserInterface $user, Request $request);
}
