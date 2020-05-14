<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias\Album;

use Domain\Entity\Medias\Album\Like as LikeInterface;
use Domain\Entity\Users\User as UserInterface;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Like Album Service
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
     * Like a album
     *
     * @param int $album
     * @param UserInterface $user
     * @param Request $request
     */
    public function like($album, UserInterface $user, Request $request);

    /**
     * Unlike a album
     *
     * @param int $album
     * @param UserInterface $user
     * @param Request $request
     */
    public function unlike($album, UserInterface $user, Request $request);
}
