<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Repository\Recommendations;

use Domain\Entity\Users\User;
use Domain\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Recommendation extends Repository
{
    /**
     * @return RecommendationModel[]
     */
    public function findApproved();

    /**
     * @return RecommendationModel[]
     */
    public function findPendingAndApproved();

    /**
     * @param User $user
     * @return RecommendationModel[]
     */
    public function findPendingAndApprovedFromUser(User $user);

    /**
     * @param integer $id
     * @param User $user
     * @return RecommendationModel[]
     */
    public function findOneByIdAndUser($id, User $user);
}
