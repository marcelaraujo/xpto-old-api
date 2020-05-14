<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Users;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Users\User as UserInterface;
use Domain\Value\UserType;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;
use JMS\Serializer\Annotation\Exclude;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="user",
 *      indexes={
 *          @ORM\Index(name="user_index_id", columns={"id"}),
 *          @ORM\Index(name="user_index_email", columns={"email"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User extends Persistable implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Exclude
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=1024, nullable=false)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="password", type="string", length=1024, nullable=false)
     * @Exclude
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(name="type", type="integer", length=1, nullable=true, options={"default" = 1})
     * @var int
     */
    protected $type = UserType::CREATIVE;

    /**
     * @var \Xpto\Entity\Users\Profile
     *
     * @ORM\OneToOne(targetEntity="Xpto\Entity\Users\Profile", mappedBy="user")
     */
    private $profile;

    /**
     * Set Name
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setName($name = '')
    {
        try {
            v::notEmpty()->alnum()->assert($name);

            $this->name = $name;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Name %s is invalid', $name), 500, $e);
        }
    }

    /**
     * Get the Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email
     *
     * @param string $email
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setEmail($email)
    {
        try {
            v::notEmpty()->email()->assert($email);

            $this->email = $email;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('E-mail %s is invalid', $email), 500, $e);
        }
    }

    /**
     * Get the password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set Password
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        try {
            v::notEmpty()->length(3, 1024)->assert($password);

            $this->password = $password;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException('Invalid password', 500, $e);
        }
    }

    /**
     * Get the user type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the user type
     *
     * @param int $type
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        try {
            $types = [
                UserType::CREATIVE,
                UserType::CURATOR,
                UserType::BUSINESS,
                UserType::BUSINESS,
                UserType::ADMINISTRATOR,
                UserType::SUPPORT,
            ];

            v::notEmpty()->in($types)->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is invalid', $type), 500, $e);
        }
    }
}
