<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Inbox;

use Domain\Entity\Inbox\Inbox as InboxModel;
use Domain\Entity\Users\User as UserModel;
use Domain\Repository\Inbox\Inbox as InboxRepositoryInterface;
use Xpto\Repository\Repository;
use OutOfRangeException;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Inbox extends Repository implements InboxRepositoryInterface
{
    /**
     * @see \Xpto\Repository\Repository::findAll()
     */
    public function findAll()
    {
        $Inboxs = $this->em->getRepository('Xpto\Entity\Inbox\Inbox')->findAll();

        return $Inboxs;
    }

    /**
     * @see \Xpto\Repository\Repository::findById()
     */
    public function findById($id)
    {
        $Inbox = $this->em->getRepository('Xpto\Entity\Inbox\Inbox')->findOneBy(
            [
                'id' => $id,
                'status' => [
                    InboxModel::NEWER,
                    InboxModel::ACTIVE,
                    InboxModel::READ_BY_DESTINATION,
                    InboxModel::ARCHIVED
                ]
            ]
        );

        if (null === $Inbox) {
            throw new OutOfRangeException('Inbox not found', 404);
        }

        return $Inbox;
    }

    /**
     * @see \Domain\Repository\Inbox\Inbox::findAllByUser()
     */
    public function findAllByUser(UserModel $user)
    {
        $Inbox = $this->em->getRepository('Xpto\Entity\Inbox\Inbox')->findBy(
            [
                'source' => $user,
                'status' => [
                    InboxModel::NEWER,
                    InboxModel::ACTIVE,
                    InboxModel::READ_BY_DESTINATION
                ]
            ]
        );

        return $Inbox;
    }

    /**
     * @see \Xpto\Repository\Repository::findOneByIdAndUser()
     */
    public function findOneByIdAndUser($id, UserModel $user)
    {
        $Inbox = $this->em->getRepository('Xpto\Entity\Inbox\Inbox')->findOneBy(
            [
                'id' => $id,
                'source' => $user,
                'status' => [
                    InboxModel::NEWER,
                    InboxModel::ACTIVE,
                    InboxModel::READ_BY_DESTINATION,
                    InboxModel::ARCHIVED
                ]
            ]
        );

        if (null === $Inbox) {
            throw new OutOfRangeException('Inbox not found', 404);
        }

        return $Inbox;
    }

    /**
     * @see \Xpto\Repository\Repository::findAllWithUser()
     */
    public function findAllWithUser(UserModel $user)
    {
        $messages = $this->em->getRepository('Xpto\Entity\Inbox\Inbox')
            ->createQueryBuilder('i')
            ->where('i.source = :user')
            ->orWhere('i.destination = :user')
            ->andWhere('i.status IN (:status)')
            ->setParameter('user', $user)
            ->setParameter(
                'status',
                [
                    InboxModel::NEWER,
                    InboxModel::ACTIVE,
                    InboxModel::READ_BY_DESTINATION,
                ]
            )
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $messages;
    }
}
