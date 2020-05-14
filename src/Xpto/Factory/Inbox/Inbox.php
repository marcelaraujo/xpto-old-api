<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Inbox;

use Doctrine\ORM\EntityManager;
use Xpto\Entity\Inbox\Inbox as InboxModel;
use Xpto\Repository\Users\User as UserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inbox Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Inbox
{
    /**
     *
     * @param Request $connection
     * @param EntityManager $em
     * @return InboxModel
     */
    public static function create(Request $connection, EntityManager $em)
    {
        $repository = new UserRepository($em);

        $source = $repository->findById($connection->get('source'));
        $destination = $repository->findById($connection->get('destination'));
        $message = $connection->get('body');

        $obj = new InboxModel();
        $obj->setStatus(InboxModel::NEWER);
        $obj->setStatusDestination(InboxModel::NEWER);
        $obj->setStatusSource(InboxModel::NEWER);
        $obj->setSource($source);
        $obj->setDestination($destination);
        $obj->setBody($message);

        return $obj;
    }
}
