<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Inbox;

use Domain\Entity\Inbox\Inbox as InboxModel;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Connections\Connection as ConnectionService;
use Domain\Service\Inbox\Inbox as InboxServiceInterface;
use Xpto\Repository\Inbox\Inbox as InboxRepository;
use Xpto\Factory\Inbox\Inbox as InboxFactory;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inbox Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Inbox implements InboxServiceInterface
{
    /**
     * @const string
     */
    const INBOX = 'inbox';

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $this->em = $app['orm.em'];

        $app[self::INBOX] = $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * Save an inbox message
     *
     * @param InboxModel $inbox
     * @param ConnectionService $connection
     * @return InboxModel
     */
    public function save(InboxModel $inbox, ConnectionService $connection)
    {
        if (!$connection->checkConnectivity($inbox->getSource(), $inbox->getDestination())) {
            $error = 'The user destination is not on connection list or no approved connection request';

            throw new InvalidArgumentException($error, 500);
        }

        $this->em->persist($inbox);
        $this->em->flush();

        return $inbox;
    }

    /**
     * Removes a message
     *
     * @param InboxModel $inbox
     * @return bool
     */
    public function delete(InboxModel $inbox)
    {
        $inbox->setStatus(InboxModel::DELETED);

        $this->em->persist($inbox);
        $this->em->flush();

        return true;
    }

    /**
     * Mark a message as archived
     *
     * @param InboxModel $inbox
     * @return bool
     */
    public function archive(InboxModel $inbox)
    {
        $inbox->setStatus(InboxModel::ARCHIVED);

        $this->em->persist($inbox);
        $this->em->flush();

        return true;
    }

    /**
     * Mark a message as read
     *
     * @param InboxModel $inbox
     * @return bool
     */
    public function markAsRead(InboxModel $inbox)
    {
        $inbox->setStatus(InboxModel::READ_BY_DESTINATION);

        $this->em->persist($inbox);
        $this->em->flush();

        return true;
    }

    /**
     * List all messages from user
     *
     * @param UserModel $user
     * @return \Xpto\Entity\Inbox\Inbox
     */
    public function listAllByUser(UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Inbox\Inbox */
        $repo = new InboxRepository($this->em);

        /* @var $inbox \Xpto\Entity\Inbox\Inbox */
        $inbox = $repo->findAllWithUser($user);

        return $inbox;
    }

    /**
     * Send a message
     *
     * @param Request $request
     * @param UserModel $user
     * @param ConnectionService $connection
     * @return \Xpto\Entity\Inbox\Inbox
     */
    public function send(Request $request, UserModel $user, ConnectionService $connection)
    {
        $request->attributes->set('source', $user->getId());

        if (!$request->get('destination')) {
            throw new InvalidArgumentException('The destination user is invalid');
        }

        /* @var $inbox \Xpto\Entity\Inbox\Inbox */
        $inbox = InboxFactory::create($request, $this->em);

        /* @var @service InboxService */
        $service = $this->save($inbox, $connection);

        return $inbox;
    }

    /**
     * Open a message and mark this as read
     *
     * @param int $id
     * @param UserModel $user
     * @return \Xpto\Entity\Inbox\Inbox
     */
    public function view($id, UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Inbox\Inbox */
        $repo = new InboxRepository($this->em);

        /* @var $inbox \Xpto\Entity\Inbox\Inbox */
        $inbox = $repo->findOneByIdAndUser($id, $user);

        $this->markAsRead($inbox);

        return $inbox;
    }

    /**
     * Remove a message by your id
     *
     * @param $id
     * @param UserModel $user
     * @return bool
     */
    public function removeById($id, UserModel $user)
    {
        /* @var $inbox \Xpto\Entity\Inbox\Inbox */
        $inbox = $this->view($id, $user);

        $this->delete($inbox);

        return true;
    }
    /**
     * Archive a message by your id
     *
     * @param $id
     * @param UserModel $user
     * @return bool
     */
    public function archiveById($id, UserModel $user)
    {
        /* @var $inbox \Xpto\Entity\Inbox\Inbox */
        $inbox = $this->view($id, $user);

        $this->archive($inbox);

        return true;
    }
}
