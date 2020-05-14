<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Connections;

use Domain\Entity\Connections\Connection as ConnectionModel;
use Domain\Entity\Users\User as UserModel;
use Silex\ServiceProviderInterface;

/**
 * Connection Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Connection extends ServiceProviderInterface
{
    /**
     * @param  ConnectionModel $connection
     * @return ConnectionModel
     */
    public function save(ConnectionModel $connection);

    /**
     * @param  ConnectionModel $connection
     * @return boolean
     */
    public function delete(ConnectionModel $connection);

    /**
     * @param UserModel $source
     * @param UserModel $destination
     * @return boolean
     */
    public function checkConnectivity(UserModel $source, UserModel $destination);
}
