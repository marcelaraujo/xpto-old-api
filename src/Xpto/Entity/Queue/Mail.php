<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Queue;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Queue\Mail as MailInterface;
use Domain\Value\Queue\Priority as QueuePriority;
use Domain\Value\Queue\Type as QueueType;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="queue",
 *      indexes={
 *          @ORM\Index(name="queue_index_id", columns={"id"}),
 *          @ORM\Index(name="queue_index_type_priority", columns={"type","priority"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Mail extends Persistable implements MailInterface
{
    /**
     * @var int
     */
    const SENDING = 4;

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="type", type="smallint", nullable=false)
     * @var int
     */
    protected $type = QueueType::SUBSCRIPTION;

    /**
     * @ORM\Column(name="content", type="string", length=1024, nullable=false)
     *
     * @var string
     */
    protected $content;

    /**
     * @ORM\Column(name="title", type="string", length=1024, nullable=false)
     *
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="destination", type="string", length=1024, nullable=false)
     *
     * @var string
     */
    protected $destination;

    /**
     * @ORM\Column(name="priority", type="smallint", nullable=false)
     * @var int
     */
    protected $priority = QueuePriority::NORMAL;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return mixed
     */
    public function setType($type = QueueType::SUBSCRIPTION)
    {
        try {
            $valids = [
                QueueType::SUBSCRIPTION
            ];

            v::notEmpty()->numeric()->in($valids)->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is invalid', $type), 500, $e);
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return mixed
     */
    public function setContent($content = '')
    {
        try {
            v::notEmpty()->assert($content);

            $this->content = $content;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Content %s is invalid', $content), 500, $e);
        }
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return mixed
     */
    public function setTitle($title = '')
    {
        try {
            v::notEmpty()->assert($title);

            $this->title = $title;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Title %s is invalid', $title), 500, $e);
        }
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     * @return mixed
     */
    public function setDestination($destination = '')
    {
        try {
            v::notEmpty()->email()->assert($destination);

            $this->destination = $destination;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Destination email %s is invalid', $destination), 500, $e);
        }
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return mixed
     */
    public function setPriority($priority = QueuePriority::NORMAL)
    {
        try {
            $valids = [
                QueuePriority::NORMAL
            ];

            v::notEmpty()->numeric()->in($valids)->assert($priority);

            $this->priority = $priority;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Priority %s is invalid', $priority), 500, $e);
        }
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
                static::SENDING
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->status = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Status %s is invalid', $status), 500, $e);
        }
    }
}
