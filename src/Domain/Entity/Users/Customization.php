<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Users;

use Domain\Entity\Entity as EntityInterface;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Customization extends EntityInterface
{
    /**
     * Set the type
     *
     * @param string $type
     */
    public function setType($type);

    /**
     * Get the type
     *
     * @return string
     */
    public function getType();

    /**
     * Set sent with enter to chat
     *
     * @param boolean $send
     */
    public function setSendWithEnter($send);

    /**
     * Get set with enter to chat
     *
     * @return boolean
     */
    public function getSendWithEnter();
}
