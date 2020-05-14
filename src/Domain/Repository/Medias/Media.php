<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Medias;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Media extends Repository
{
    /**
     * @param User $user
     */
    public function findByUser(User $user);

    /**
     * @param $id
     * @param User $user
     * @return mixed
     */
    public function findOneByIdAndUser($id, User $user);
}
