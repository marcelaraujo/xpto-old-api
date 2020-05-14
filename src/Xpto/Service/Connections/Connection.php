<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Connections;

use Domain\Entity\Connections\Connection as ConnectionModel;
use Domain\Entity\Users\User as UserModel;
use Domain\Service\Connections\Connection as ConnectionServiceInterface;
use Xpto\Factory\Connections\Connection as ConnectionFactory;
use Xpto\Repository\Connections\Connection as ConnectionRepository;
use Xpto\Repository\Users\Profile as ProfileRepository;
use InvalidArgumentException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Connection Service
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Connection implements ConnectionServiceInterface
{
    /**
     * @const string
     */
    const CONNECTION = 'connection';

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

        $app[self::CONNECTION] = $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * Save an connection
     *
     * @param  ConnectionModel $connection
     * @return ConnectionModel
     */
    public function save(ConnectionModel $connection)
    {
        $this->em->persist($connection);
        $this->em->flush();

        return $connection;
    }

    /**
     * Remove a connection
     *
     * @param  ConnectionModel $connection
     * @return boolean
     */
    public function delete(ConnectionModel $connection)
    {
        if ($connection->isDeleted()) {
            throw new InvalidArgumentException('This connection is already deleted.');
        }

        $connection->setStatus(ConnectionModel::DELETED);

        $this->em->persist($connection);
        $this->em->flush();

        return true;
    }

    /**
     * Check connectiviy between users
     *
     * @param UserModel $source
     * @param UserModel $destination
     * @return boolean
     */
    public function checkConnectivity(UserModel $source, UserModel $destination)
    {
        $connection = $this->em->getRepository('Xpto\Entity\Connections\Connection')
            ->createQueryBuilder('i')
            ->where('i.status IN (:status)')
            ->andWhere('i.source = :source and i.destination = :destination')
            ->orWhere('i.source = :destination or i.destination = :source')
            ->setParameter('source', $source)
            ->setParameter('destination', $destination)
            ->setParameter(
                'status',
                [
                    ConnectionModel::APPROVED
                ]
            )
            ->orderBy('i.id', 'DESC')
            ->getQuery()
            ->getResult();

        return count($connection) !== 0;
    }

    /**
     * View connection from id and user
     *
     * @param $connectionId
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection
     */
    public function view($connectionId, UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Connections\Connection */
        $repo = new ConnectionRepository($this->em);

        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $repo->findOneByIdAndUser($connectionId, $user);

        return $connection;
    }

    /**
     * List pending connections from an user
     *
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection[]
     */
    public function listPendingByUser(UserModel $user)
    {
        /* @var $repo \Xpto\Repository\Connections\Connection */
        $repo = new ConnectionRepository($this->em);

        /* @var $connections \Xpto\Entity\Connections\Connection[] */
        $connections = $repo->findPendingAndApprovedFromUser($user);

        return $connections;
    }

    /**
     * List approved connections from an user
     *
     * @param string $nickname
     * @return \Xpto\Entity\Connections\Connection[]
     */
    public function listApprovedByNickname($nickname)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $repositoryProfile = new ProfileRepository($this->em);
        $profile = $repositoryProfile->findByNickname($nickname);

        /* @var $repositoryConnection \Xpto\Repository\Connections\Connection */
        $repositoryConnection = new ConnectionRepository($this->em);

        /* @var $connections \Xpto\Entity\Connections\Connection */
        $connections = $repositoryConnection->findApprovedFromUser($profile->getUser());

        return $connections;
    }

    /**
     * List approved connections from an user id
     *
     * @param int $userId
     * @return \Xpto\Entity\Connections\Connection[]
     */
    public function listApprovedByUserId($userId)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $repositoryProfile = new ProfileRepository($this->em);
        $profile = $repositoryProfile->findByUser($userId);

        /* @var $repositoryConnection \Xpto\Repository\Connections\Connection */
        $repositoryConnection = new ConnectionRepository($this->em);

        /* @var $connections \Xpto\Entity\Connections\Connection */
        $connections = $repositoryConnection->findApprovedFromUser($profile->getUser());

        return $connections;
    }

    /**
     * List connections from nickname
     *
     * @param $nickname
     * @return \Xpto\Entity\Connections\Connection
     */
    public function listByNickname($nickname)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $repositoryProfile = new ProfileRepository($this->em);
        $profile = $repositoryProfile->findByNickname($nickname);

        /* @var $repo \Xpto\Repository\Connections\Connection */
        $repo = new ConnectionRepository($this->em);

        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $repo->findOneByIdAndUser($profile->getUser()->getId(), $profile->getUser());

        return $connection;
    }

    /**
     * List connections from profile
     *
     * @param int $id
     * @return \Xpto\Entity\Connections\Connection[]
     */
    public function listByProfileId($id)
    {
        /* @var $profile \Xpto\Entity\Users\Profile */
        $repositoryProfile = new ProfileRepository($this->em);
        $profile = $repositoryProfile->findById($id);

        /* @var $repositoryConnection \Xpto\Repository\Connections\Connection */
        $repositoryConnection = new ConnectionRepository($this->em);

        /* @var $connections \Xpto\Entity\Connections\Connection */
        $connections = $repositoryConnection->findApprovedFromUser($profile->getUser());

        return $connections;
    }

    /**
     * Perform a connection between users
     *
     * @param Request $request
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection
     */
    public function connect(Request $request, UserModel $user)
    {
        /* @var $req \Symfony\Component\HttpFoundation\Request */
        $request->attributes->set('source', $user->getId());

        if (!$request->get('destination')) {
            throw new InvalidArgumentException('The destination user is invalid');
        }

        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = ConnectionFactory::create($request, $this->em);

        return $this->save($connection);
    }

    /**
     * Approve a connection solicitation
     *
     * @param int $id
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection
     */
    public function approve($id, UserModel $user)
    {
        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $this->view($id, $user);
        $connection->setStatus(ConnectionModel::APPROVED);

        $this->save($connection);

        return $connection;
    }

    /**
     * Decline a connection solicitation
     *
     * @param int $id
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection
     */
    public function decline($id, UserModel $user)
    {
        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $this->view($id, $user);
        $connection->setStatus(ConnectionModel::REPPROVED);

        $this->save($connection);

        return $connection;
    }

    /**
     * Update a connection
     *
     * @param int $id
     * @param Request $request
     * @param UserModel $user
     * @return \Xpto\Entity\Connections\Connection
     */
    public function update($id, Request $request, UserModel $user)
    {
        /* @var $connection \Xpto\Entity\Connections\Connection */
        $connection = $this->view($id, $user);

        /* @var $result \Xpto\Entity\Connections\Connection */
        $result = $this->save(ConnectionFactory::update($connection, $request));

        return $result;
    }

    /**
     * Remove a connection by your id
     *
     * @param int $id
     * @param UserModel $user
     * @return bool
     */
    public function remove($id, UserModel $user)
    {
        $connection = $this->view($id, $user);
        $this->delete($connection);

        return true;
    }
}
