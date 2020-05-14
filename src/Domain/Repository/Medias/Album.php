<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Medias;

use Domain\Entity\Users\User as UserModel;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Album extends Repository
{
    /**
     * @param integer $type
     * @return Album[]
     */
    public function findByType($type);

    /**
     * @param UserModel $user
     * @param integer $type
     * @return Album[]
     */
    public function findOneByUserAndType(UserModel $user, $type);

    /**
     * @param UserModel $user
     * @param integer $type
     * @return Album[]
     */
    public function findByUserAndType(UserModel $user, $type);

    /**
     * @param int $id
     * @param UserModel $user
     * @return mixed
     */
    public function findOneByIdAndUser($id, UserModel $user);
}
