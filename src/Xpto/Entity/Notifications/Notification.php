<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Notifications;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Notifications\Notification as NotificationInterface;
use Domain\Entity\Users\User;
use Domain\Value\NotificationType;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 * Notification Entity
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="notification",
 *      indexes={
 *          @ORM\Index(name="notification_index_id",   columns={"id"}),
 *          @ORM\Index(name="notification_index_user", columns={"user_id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Notification extends Persistable implements NotificationInterface
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
     * @ORM\Column(name="content", type="text", nullable=false)
     *
     * @var string
     */
    protected $content;

    /**
     * @ORM\Column(name="type", type="integer", length=1024, nullable=false)
     *
     * @var integer
     */
    protected $type = NotificationType::INFO;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    protected $user;

    /**
     * @see \Domain\Entity\Notifications\Notification::getContent()
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @see \Domain\Entity\Notifications\Notification::setContent()
     */
    public function setContent($content)
    {
        try {
            v::notEmpty()->assert($content);

            $this->content = $content;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('Content must not be empty', 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Media::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @see \Domain\Entity\Media::setType()
     */
    public function setType($type)
    {
        $types = [
            NotificationType::INFO,
            NotificationType::ALERT,
            NotificationType::ERROR
        ];

        try {
            v::notEmpty()->in($types)->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is not allowed', $type), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Medias\Media::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @see \Domain\Entity\Medias\Media::setUser()
     */
    public function setUser(User $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('Deleted users can not receive a notification', 500);
        }

        $this->user = $user;
    }

    /**
     * @see \Domain\Entity\Notifications\Notification::setStatus()
     */
    public function setStatus($status)
    {
        try {
            $validStatus = [
                static::NEWER,
                static::ACTIVE,
                static::ARCHIVED,
                static::DELETED,
                static::READ,
            ];

            v::notEmpty()->int()->in($validStatus)->assert($status);

            $this->status = $status;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Status %s is invalid', $status), 500, $e);
        }
    }
}
