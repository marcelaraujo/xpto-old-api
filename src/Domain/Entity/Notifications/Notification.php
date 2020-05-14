<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Notifications;

use Domain\Entity\Entity as EntityInterface;
use Domain\Entity\Users\User;

/**
 * Notification interface
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Notification extends EntityInterface
{
    /**
     * Read
     *
     * @var int
     */
    const READ = 4;

    /**
     * Archived
     *
     * @var int
     */
    const ARCHIVED = 5;

    /**
     * Get notification type
     *
     * @return int
     */
    public function getType();

    /**
     * Set notification type
     *
     * @param  int $type
     * @return void
     */
    public function setType($type);

    /**
     * Get notification content
     *
     * @return string
     */
    public function getContent();

    /**
     * Set the notification content
     *
     * @param  string $content
     * @return void
     */
    public function setContent($content);

    /**
     * Get notification user
     *
     * @return string
     */
    public function getUser();

    /**
     * Set notification user
     *
     * @param  User $user
     * @return void
     */
    public function setUser(User $user);
}
