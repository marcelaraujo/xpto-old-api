<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Repository;

use Doctrine\ORM\EntityManager;
use Domain\Repository\Repository as RepositoryInterface;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
