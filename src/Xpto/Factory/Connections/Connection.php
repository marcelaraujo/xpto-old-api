<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Connections;

use Doctrine\ORM\EntityManager;
use Xpto\Entity\Connections\Connection as ConnectionModel;
use Xpto\Repository\Users\User as UserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Connection Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Connection
{
    /**
     *
     * @param Request $connection
     * @param EntityManager $em
     * @return ConnectionModel
     */
    public static function create(Request $connection, EntityManager $em)
    {
        $repository = new UserRepository($em);

        $source = $repository->findById($connection->get('source'));
        $destination = $repository->findById($connection->get('destination'));

        $obj = new ConnectionModel();
        $obj->setStatus(ConnectionModel::NEWER);
        $obj->setSource($source);
        $obj->setDestination($destination);

        return $obj;
    }

    /**
     *
     * @param ConnectionModel $user
     * @param Request $req
     * @return ConnectionModel
     */
    public static function update(ConnectionModel $connection, Request $req)
    {
        $connection->setStatus($req->get('status'));

        return $connection;
    }
}
