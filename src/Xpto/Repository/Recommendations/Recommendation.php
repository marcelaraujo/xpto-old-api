<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Recommendations;

use Domain\Entity\Recommendations\Recommendation as RecommendationModel;
use Domain\Entity\Users\User;
use Domain\Repository\Recommendations\Recommendation as RecommendationRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Recommendation extends Repository implements RecommendationRepositoryInterface
{
    /**
     * @see RecommendationRepositoryInterface::findAll()
     */
    public function findAll()
    {
        $recommendations = $this->em->getRepository('Xpto\Entity\Recommendations\Recommendation')->findAll();

        return $recommendations;
    }

    /**
     * @see RecommendationRepositoryInterface::findById()
     */
    public function findById($id)
    {
        $recommendation = $this->em->getRepository('Xpto\Entity\Recommendations\Recommendation')->findOneBy(
            [
                'id' => $id,
                'status' => [
                    RecommendationModel::APPROVED,
                    RecommendationModel::ACTIVE,
                    RecommendationModel::NEWER
                ]
            ]
        );

        if (null === $recommendation || $recommendation->isDeleted()) {
            throw new OutOfRangeException('Recommendation not found', 404);
        }

        return $recommendation;
    }

    /**
     * @return RecommendationModel[]
     */
    public function findApproved()
    {
        $recommendations = $this->em->getRepository('Xpto\Entity\Recommendations\Recommendation')->findBy(
            [
                'status' => RecommendationModel::APPROVED
            ]
        );

        return $recommendations;
    }

    /**
     * @return RecommendationModel[]
     */
    public function findPendingAndApproved()
    {
        $recommendations = $this->em->getRepository('Xpto\Entity\Recommendations\Recommendation')->findBy(
            [
                'status' => [
                    RecommendationModel::APPROVED,
                    RecommendationModel::ACTIVE,
                    RecommendationModel::NEWER,
                ]
            ]
        );

        return $recommendations;
    }

    /**
     * @param User $user
     * @return RecommendationModel[]
     */
    public function findPendingAndApprovedFromUser(User $user)
    {
        $recommendations = $this->em
            ->getRepository('Xpto\Entity\Recommendations\Recommendation')
            ->createQueryBuilder('i')
            ->where('i.source = :user')
            ->orWhere('i.destination = :user')
            ->andWhere('i.status IN (:status)')
            ->setParameter('user', $user)
            ->setParameter(
                'status',
                [
                    RecommendationModel::APPROVED,
                    RecommendationModel::ACTIVE,
                    RecommendationModel::NEWER,
                ]
            )
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $recommendations;
    }

    /**
     * @see RecommendationRepositoryInterface::findByIdAndUser()
     */
    public function findOneByIdAndUser($id, User $user)
    {
        try {
            $recommendation = $this->em
                ->getRepository('Xpto\Entity\Recommendations\Recommendation')
                ->createQueryBuilder('i')
                ->where('i.id = :id')
                ->andWhere('i.status IN (:status)')
                ->andWhere('(i.source = :user OR i.destination = :user)')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
                ->setParameter(
                    'status',
                    [
                        RecommendationModel::APPROVED,
                        RecommendationModel::ACTIVE,
                        RecommendationModel::NEWER
                    ]
                )
                ->orderBy('i.id', 'DESC')
                ->getQuery()
                ->getSingleResult();

            if (null === $recommendation || $recommendation->isDeleted()) {
                throw new OutOfRangeException('Connection not found', 404);
            }

            return $recommendation;
        } catch (\Exception $ex) {
            throw new OutOfRangeException('Connection not found', 404);
        }
    }

    /**
     * @see RecommendationRepositoryInterface::findByIdAndUser()
     */
    public function findApprovedFromUser(User $user)
    {
        try {
            $recommendation = $this->em
                ->getRepository('Xpto\Entity\Recommendations\Recommendation')
                ->createQueryBuilder('i')
                ->where('i.id > 0')
                ->andWhere('i.status IN (:status)')
                ->andWhere('(i.source = :user OR i.destination = :user)')
                ->setParameter('user', $user)
                ->setParameter(
                    'status',
                    [
                        RecommendationModel::APPROVED,
                    ]
                )
                ->orderBy('i.id', 'DESC')
                ->getQuery()
                ->getResult();

            return $recommendation;
        } catch (\Exception $ex) {
            throw new OutOfRangeException('Connections not found', 404);
        }
    }
}
