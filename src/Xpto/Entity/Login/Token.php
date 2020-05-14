<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Login;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Login\Token as TokenInterface;
use Domain\Entity\Users\User;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Rhumsaa\Uuid\Uuid;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 *
 * @ORM\Table(
 *      name="token",
 *      indexes={
 *          @ORM\Index(name="token_index_id", columns={"id"}),
 *          @ORM\Index(name="token_index_user", columns={"user_id"}),
 *          @ORM\Index(name="token_index_content", columns={"content"}),
 *          @ORM\Index(name="token_index_content_user", columns={"content", "user_id"})
 *      },
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="token_unique_content", columns={"content"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Token extends Persistable implements TokenInterface
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
     * @ORM\Column(name="content", type="string", length=128, nullable=false)
     * @var string
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="\Xpto\Entity\Users\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var \Xpto\Entity\Users\User
     */
    protected $user;

    /**
     * @ORM\Column(name="expiration", type="datetime", nullable=true, options={"default" = "CURRENT_TIMESTAMP"})
     * @var DateTime
     */
    protected $expiration;

    /**
     * @ORM\Column(name="address", type="string", length=1024, nullable=true)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(name="agent", type="string", length=1024, nullable=true)
     * @var string
     */
    protected $agent;

    /**
     * @see \Domain\Entity\Users\User::getUser()
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @see \Domain\Entity\Users\User::setUser()
     */
    public function setUser(User $user)
    {
        if ($user->isDeleted()) {
            throw new InvalidArgumentException('User is deleted', 500);
        }

        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        if (false === Uuid::isValid($content)) {
            throw new InvalidArgumentException('The token is invalid', 500);
        }

        $this->content = $content;
    }

    /**
     * Get the expiration date
     *
     * @return DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param DateTime $expiration
     * @return void
     */
    public function setExpiration(DateTime $expiration)
    {
        if ($expiration < $this->created) {
            throw new InvalidArgumentException('Expiration cannot be less than create attribute', 500);
        }

        $this->expiration = $expiration;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return the $agent
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param string $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }
}
