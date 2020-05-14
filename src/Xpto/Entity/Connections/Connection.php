<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Connections;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Connections\Connection as ConnectionInterface;
use Domain\Entity\Users\User;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="connection",
 *      indexes={
 *          @ORM\Index(name="connection_index_id", columns={"id"}),
 *          @ORM\Index(name="connection_index_source", columns={"source"}),
 *          @ORM\Index(name="connection_index_destination", columns={"destination"}),
 *          @ORM\Index(name="connection_index_source_destination", columns={"destination","source"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Connection extends Persistable implements ConnectionInterface
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="source", referencedColumnName="id")
     *
     * @var User
     */
    protected $source;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="destination", referencedColumnName="id")
     *
     * @var User
     */
    protected $destination;

    /**
     * @see \Domain\Entity\Connections\Connection::setSource()
     */
    public function setSource(User $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('User source is deleted', 500);
        }

        $this->source = $user;
    }

    /**
     * @see \Domain\Entity\Connections\Connection::getSource()
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @see \Domain\Entity\Connections\Connection::setDestination()
     */
    public function setDestination(User $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('User destination is deleted', 500);
        }

        $this->destination = $user;
    }

    /**
     * @see \Domain\Entity\Connections\Connection::getDestination()
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @see \Domain\Entity\Connections\Connection::isApproved()
     */
    public function isApproved()
    {
        return $this->status === static::APPROVED;
    }

    /**
     * @see \Domain\Entity\Entity::setStatus()
     *
     * @throws InvalidArgumentException
     */
    public function setStatus($status)
    {
        try {
            $validStatus = [
                static::NEWER,
                static::ACTIVE,
                static::DELETED,
                static::APPROVED,
                static::REPPROVED
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->status = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Status %s is invalid', $status), 500, $e);
        }
    }
}
