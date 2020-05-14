<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Connections;

use Domain\Entity\Connections\Connection as ConnectionModel;
use Domain\Entity\Users\User;
use Domain\Repository\Connections\Connection as ConnectionRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Connection extends Repository implements ConnectionRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $connections = $this->em->getRepository('Xpto\Entity\Connections\Connection')->findAll();

        return $connections;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $connection = $this->em->getRepository('Xpto\Entity\Connections\Connection')->findOneById($id);

        if (null === $connection || $connection->isDeleted()) {
            throw new OutOfRangeException('Connection not found', 404);
        }

        return $connection;
    }

    /**
     * @return ConnectionModel[]
     */
    public function findApproved()
    {
        $connections = $this->em->getRepository('Xpto\Entity\Connections\Connection')->findBy(
            [
                'status' => ConnectionModel::APPROVED
            ]
        );

        return $connections;
    }

    /**
     * @return ConnectionModel[]
     */
    public function findPendingAndApproved()
    {
        $connections = $this->em->getRepository('Xpto\Entity\Connections\Connection')->findBy(
            [
                'status' => [
                    ConnectionModel::APPROVED,
                    ConnectionModel::ACTIVE,
                ]
            ]
        );

        return $connections;
    }

    /**
     * @param User $user
     * @return ConnectionModel[]
     */
    public function findPendingAndApprovedFromUser(User $user)
    {
        $connections = $this->em->getRepository('Xpto\Entity\Connections\Connection')
            ->createQueryBuilder('i')
            ->where('i.source = :user')
            ->orWhere('i.destination = :user')
            ->andWhere('i.status IN (:status)')
            ->setParameter('user', $user)
            ->setParameter(
                'status',
                [
                    ConnectionModel::APPROVED,
                    ConnectionModel::ACTIVE,
                    ConnectionModel::NEWER
                ]
            )
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $connections;
    }

    /**
     * @param User $user
     * @return ConnectionModel[]
     */
    public function findApprovedFromUser(User $user)
    {
        try {
            $connections = $this->em->getRepository('Xpto\Entity\Connections\Connection')
                ->createQueryBuilder('i')
                ->where('i.id > 0')
                ->andWhere('i.status IN (:status)')
                ->andWhere('(i.source = :user OR i.destination = :user)')
                ->setParameter('user', $user)
                ->setParameter(
                    'status',
                    [
                        ConnectionModel::APPROVED,
                    ]
                )
                ->orderBy('i.id', 'DESC')
                ->getQuery()
                ->getResult();

            return $connections;
        } catch (\Exception $ex) {
            throw new OutOfRangeException(sprintf('Error listening connections: %s', $ex->getMessage()), 500);
        }
    }

    /**
     * @see \Xpto\Repository\Repository::findOneByIdAndUser()
     */
    public function findOneByIdAndUser($id, User $user)
    {
        try {
            $connection = $this->em->getRepository('Xpto\Entity\Connections\Connection')
                ->createQueryBuilder('i')
                ->where('i.id = :id')
                ->andWhere('i.status IN (:status)')
                ->andWhere('(i.source = :user OR i.destination = :user)')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
                ->setParameter(
                    'status',
                    [
                        ConnectionModel::APPROVED,
                        ConnectionModel::ACTIVE,
                        ConnectionModel::NEWER,
                    ]
                )
                ->orderBy('i.id', 'DESC')
                ->getQuery()
                ->getSingleResult();

            if (null === $connection || $connection->isDeleted()) {
                throw new OutOfRangeException('Connection not found', 404);
            }

            return $connection;
        } catch (\Exception $ex) {
            throw new OutOfRangeException('Connection not found', 404);
        }
    }
}
