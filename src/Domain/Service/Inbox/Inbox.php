<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Service\Inbox;

use Domain\Entity\Inbox\Inbox as InboxModel;
use Domain\Service\Connections\Connection as ConnectionService;
use Silex\ServiceProviderInterface;

/**
 * Inbox Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Inbox extends ServiceProviderInterface
{
    /**
     * @param  InboxModel $inbox
     * @param  ConnectionService $connection
     * @return mixed
     */
    public function save(InboxModel $inbox, ConnectionService $connection);

    /**
     * @param InboxModel $inbox
     * @return mixed
     */
    public function delete(InboxModel $inbox);
}
