<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Notifications;

use Domain\Entity\Notifications\Notification as NotificationModel;
use Domain\Entity\Users\User;
use Domain\Repository\Notifications\Notification as NotificationRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * Notification Repository
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Notification extends Repository implements NotificationRepositoryInterface
{
    /**
     * @see NotificationRepositoryInterface::findAll()
     */
    public function findAll()
    {
        $recommendations = $this->em->getRepository('Xpto\Entity\Notifications\Notification')->findBy(
            [
                'status' => [
                    NotificationModel::ACTIVE,
                    NotificationModel::NEWER
                ]
            ]
        );

        return $recommendations;
    }

    /**
     * @see NotificationRepositoryInterface::findAll()
     */
    public function findByUser(User $user)
    {
        $recommendations = $this->em->getRepository('Xpto\Entity\Notifications\Notification')->findBy(
            [
                'user' => $user,
                'status' => [
                    NotificationModel::ACTIVE,
                    NotificationModel::NEWER
                ]
            ]
        );

        return $recommendations;
    }

    /**
     * @see NotificationRepositoryInterface::findById()
     */
    public function findById($id)
    {
        $recommendation = $this->em->getRepository('Xpto\Entity\Notifications\Notification')->findOneBy(
            [
                'id' => $id,
                'status' => [
                    NotificationModel::ACTIVE,
                    NotificationModel::NEWER
                ]
            ]
        );

        if (null === $recommendation || $recommendation->isDeleted()) {
            throw new OutOfRangeException('Notification not found', 404);
        }

        return $recommendation;
    }

    /**
     * @see NotificationRepositoryInterface::findByIdAndUser()
     */
    public function findOneByIdAndUser($id, User $user)
    {
        try {
            $recommendation = $this->em
                ->getRepository('Xpto\Entity\Notifications\Notification')
                ->createQueryBuilder('i')
                ->where('i.id = :id')
                ->andWhere('i.status IN (:status)')
                ->andWhere('i.user = :user')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
                ->setParameter(
                    'status',
                    [
                        NotificationModel::ACTIVE,
                        NotificationModel::NEWER
                    ]
                )
                ->orderBy('i.id', 'DESC')
                ->getQuery()
                ->getSingleResult();

            if (null === $recommendation || $recommendation->isDeleted()) {
                throw new OutOfRangeException('Notification not found', 404);
            }

            return $recommendation;
        } catch (\Exception $ex) {
            throw new OutOfRangeException('Notification not found', 404);
        }
    }
}
