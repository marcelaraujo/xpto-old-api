<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Users;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Users\Customization as CustomizationInterface;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="customization",
 *      indexes={
 *          @ORM\Index(name="customization_index_id", columns={"id"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Customization extends Persistable implements CustomizationInterface
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
     * @ORM\Column(name="send_with_enter", type="boolean", nullable=true, options={"default" = true})
     *
     * @var boolean
     */
    protected $sendWithEnter;

    /**
     * @ORM\Column(name="type", type="integer", nullable=true, options={"default" = 1})
     *
     * @var int
     */
    protected $type;

    /**
     * @see \Domain\Entity\Customization::setSendWithEnter()
     */
    public function setSendWithEnter($send)
    {
        try {
            v::notEmpty()->bool()->assert($send);

            $this->sendWithEnter = $send;
        } catch (AllOfException $e) {
            $message = sprintf('SendWithEnter property must be a boolean, "%s" is invalid', $send);

            throw new InvalidArgumentException($message, 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Customization::getSendWithEnter()
     */
    public function getSendWithEnter()
    {
        return $this->sendWithEnter;
    }

    /**
     * @see \Domain\Entity\Customization::setType()
     */
    public function setType($type)
    {
        try {
            v::notEmpty()->int()->assert($type);

            $this->type = $type;
        } catch (AllOfException $e) {
            throw new InvalidArgumentException(sprintf('Type %s is not allowed', $type), 500, $e);
        }
    }

    /**
     * @see \Domain\Entity\Customization::getType()
     */
    public function getType()
    {
        return $this->type;
    }
}
