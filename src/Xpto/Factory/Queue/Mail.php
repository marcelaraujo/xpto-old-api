<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Queue;

use Xpto\Entity\Queue\Mail as MailModel;

/**
 * Inbox Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Mail
{
    /**
     * @param string $to
     * @param string $title
     * @param string $content
     * @return MailModel
     */
    public static function create($to = '', $title = '', $content = '')
    {
        $obj = new MailModel();
        $obj->setStatus(MailModel::NEWER);
        $obj->setDestination($to);
        $obj->setTitle($title);
        $obj->setContent($content);

        return $obj;
    }

    /**
     * @param string $to
     * @return MailModel
     */
    public static function welcome($to = '')
    {
        $mail = self::create($to, 'Welcome to xpto', 'Bem vindo');

        return $mail;
    }
}
