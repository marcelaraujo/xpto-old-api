<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Inbox;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Inbox\Inbox as InboxInterface;
use Domain\Entity\Users\User;
use Xpto\Entity\Entity;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="inbox",
 *      indexes={
 *          @ORM\Index(name="inbox_index_id", columns={"id"}),
 *          @ORM\Index(name="inbox_index_source", columns={"source"}),
 *          @ORM\Index(name="inbox_index_destination", columns={"destination"}),
 *          @ORM\Index(name="inbox_index_source_destination", columns={"destination","source"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Inbox extends Entity implements InboxInterface
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
     * @ORM\Column(name="body", type="string", length=1024, nullable=false)
     * @var string
     */
    protected $body;

    /**
     * @ORM\Column(name="status_source", type="smallint", nullable=true, options={"default" = 1})
     * @var int
     */
    protected $statusSource;

    /**
     * @ORM\Column(name="status_destination", type="smallint", nullable=true, options={"default" = 1})
     * @var int
     */
    protected $statusDestination;

    /**
     * @see \Domain\Entity\Inbox\Inbox::setSource()
     */
    public function setSource(User $source)
    {
        if ($source->isDeleted()) {
            throw new InvalidArgumentException('The user source is deleted', 500);
        }

        $this->source = $source;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::getStatusSource()
     */
    public function getStatusSource()
    {
        return $this->statusSource;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::getDestination()
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::setStatusSource()
     */
    public function setStatusSource($status)
    {
        try {
            $validStatus = [
                static::ACTIVE,
                static::ARCHIVED,
                static::DELETED,
                static::NEWER,
                static::READ_BY_DESTINATION,
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->statusSource = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Source status %s is invalid', $status), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::getBody()
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::setStatusDestination()
     */
    public function setStatusDestination($status)
    {
        try {
            $validStatus = [
                static::ACTIVE,
                static::ARCHIVED,
                static::DELETED,
                static::NEWER,
                static::READ_BY_DESTINATION
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->statusDestination = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Destination status %s is invalid', $status), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::setBody()
     */
    public function setBody($body)
    {
        try {
            v::notEmpty()->assert($body);

            $this->body = $body;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('The body message is invalid', 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::setDestination()
     */
    public function setDestination(User $destination)
    {
        if ($destination->isDeleted()) {
            throw new InvalidArgumentException('The user destination is deleted', 500);
        }

        $this->destination = $destination;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::getSource()
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::getStatusDestination()
     */
    public function getStatusDestination()
    {
        return $this->statusDestination;
    }

    /**
     * @see \Domain\Entity\Inbox\Inbox::setStatus()
     */
    public function setStatus($status)
    {
        try {
            $validStatus = [
                static::ACTIVE,
                static::ARCHIVED,
                static::DELETED,
                static::NEWER,
                static::READ_BY_DESTINATION,
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->status = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Destination status %s is invalid', $status), 500, $e);
        }
    }
}
