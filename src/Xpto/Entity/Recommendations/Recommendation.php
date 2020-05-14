<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Entity\Recommendations;

use Doctrine\ORM\Mapping as ORM;
use Domain\Entity\Recommendations\Recommendation as RecommendationInterface;
use Domain\Entity\Users\User;
use Xpto\Entity\Entity as Persistable;
use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator as v;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 *
 * @ORM\Table(
 *      name="recommendation",
 *      indexes={
 *          @ORM\Index(name="recommendation_index_id", columns={"id"}),
 *          @ORM\Index(name="recommendation_index_source", columns={"source"}),
 *          @ORM\Index(name="recommendation_index_destination", columns={"destination"}),
 *          @ORM\Index(name="recommendation_index_source_destination", columns={"source","destination"})
 *      }
 * )
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Recommendation extends Persistable implements RecommendationInterface
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
     * @ORM\Column(name="message", type="string", length=1024, nullable=false)
     * @var string
     */
    protected $message;

    /**
     *
     * @see \Domain\Entity\Recommendation::isApproved()
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

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::setMessage()
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::getMessage()
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::setSource()
     */
    public function setSource(User $source)
    {
        if ($source->isDeleted()) {
            throw new InvalidArgumentException('The user source is already deleted', 500);
        }

        $this->source = $source;
    }

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::getSource()
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::setDestination()
     */
    public function setDestination(User $destination)
    {
        if ($destination->isDeleted()) {
            throw new InvalidArgumentException('The user destination is already deleted', 500);
        }

        $this->destination = $destination;
    }

    /**
     * @see \Domain\Entity\Recommendations\Recommendation::getDestination()
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
