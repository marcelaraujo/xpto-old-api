<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository\Queue;

use Doctrine\ORM\EntityManager;
use Domain\Repository\Queue\Mail as MailInterface;
use Xpto\Repository\Repository;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Mail extends Repository implements MailInterface
{
    /**
     * @var \Domain\Repository\Queue\Mail
     */
    protected $repository;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);

        $this->repository = $this->em->getRepository('\Xpto\Entity\Queue\Mail');
    }

    /**
     * @see \Domain\Repository\Queue\Mail::findByStatus
     */
    public function findByStatus($status = 0)
    {
        return $this->repository->findByStatus($status);
    }

    /**
     * @see \Domain\Repository\Repository::findAll
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @see \Domain\Repository\Repository::findById
     */
    public function findById($id)
    {
        return $this->repository->findOneById($id);
    }
}
