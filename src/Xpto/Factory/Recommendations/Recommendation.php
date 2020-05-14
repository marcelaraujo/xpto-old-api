<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Recommendations;

use Doctrine\ORM\EntityManager;
use Xpto\Entity\Recommendations\Recommendation as RecommendationModel;
use Xpto\Repository\Users\User as UserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Recommendation Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Recommendation
{
    /**
     *
     * @param Request $connection
     * @param EntityManager $em
     * @return RecommendationModel
     */
    public static function create(Request $connection, EntityManager $em)
    {
        $repository = new UserRepository($em);

        $source = $repository->findById($connection->get('source'));
        $destination = $repository->findById($connection->get('destination'));
        $message = $connection->get('message');

        $obj = new RecommendationModel();
        $obj->setStatus(RecommendationModel::NEWER);
        $obj->setSource($source);
        $obj->setDestination($destination);
        $obj->setMessage($message);

        return $obj;
    }

    /**
     *
     * @param RecommendationModel $user
     * @param Request $req
     * @return RecommendationModel
     */
    public static function update(RecommendationModel $connection, Request $req)
    {
        if ($req->attributes->has('status')) {
            $connection->setStatus($req->get('status'));
        }

        if ($req->attributes->has('message')) {
            $connection->setMessage($req->get('message'));
        }

        return $connection;
    }
}
