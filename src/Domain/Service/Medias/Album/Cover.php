<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Medias\Album;

use Domain\Entity\Medias\Album as AlbumInterface;
use Domain\Entity\Users\User as UserInterface;
use Silex\ServiceProviderInterface;

/**
 * Like Album Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Cover extends ServiceProviderInterface
{
    /**
     * @param UserInterface $user
     * @return AlbumInterface
     */
    public function listByUser(UserInterface $user);
}
