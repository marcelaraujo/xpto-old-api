<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Recommendations;

use Domain\Entity\Users\User as UserModel;
use Domain\Entity\Recommendations\Recommendation as RecommendationModel;
use Domain\Service\Connections\Connection as ConnectionService;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Recommendation extends ServiceProviderInterface
{
    /**
     * @param  RecommendationModel $recommendation
     * @param  ConnectionService $connection
     * @return RecommendationModel
     */
    public function save(RecommendationModel $recommendation, ConnectionService $connection);

    /**
     * @param  RecommendationModel $recommendation
     * @return boolean
     */
    public function delete(RecommendationModel $recommendation);

    /**
     * @param UserModel $user
     * @return RecommendationModel[]
     */
    public function listByUser(UserModel $user);

    /**
     * @param int $id
     * @param UserModel $user
     * @return RecommendationModel
     */
    public function view($id, UserModel $user);

    /**
     * @param UserModel $recommender
     * @param UserModel $recommended
     * @param Request $request
     * @param ConnectionService $connection
     */
    public function recommend(
        UserModel $recommender,
        UserModel $recommended,
        Request $request,
        ConnectionService $connection
    );

    /**
     * @param int $id
     * @param UserModel $recommended
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function approve($id, UserModel $recommended);

    /**
     * @param int $id
     * @param UserModel $recommended
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function reprove($id, UserModel $recommended);

    /**
     * @param int $id
     * @param UserModel $recommender
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function remove($id, UserModel $recommender);

    /**
     * @param int $id
     * @param UserModel $recommender
     * @param Request $request
     * @return \Xpto\Entity\Recommendations\Recommendation
     */
    public function update($id, UserModel $recommender, Request $request);
}
