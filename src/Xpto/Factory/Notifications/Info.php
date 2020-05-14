<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Notifications;

use Domain\Value\NotificationType;
use Xpto\Entity\Notifications\Notification as NotificationModel;

/**
 * Inbox Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Info
{
    /**
     * @param string $to
     * @param string $content
     * @return MailModel
     */
    public static function create($to = '', $content = '')
    {
        $notification = new NotificationModel;
        $notification->setContent($content);
        $notification->setStatus(NotificationModel::NEWER);
        $notification->setType(NotificationType::INFO);
        $notification->setUser($to);

        return $notification;
    }
}
