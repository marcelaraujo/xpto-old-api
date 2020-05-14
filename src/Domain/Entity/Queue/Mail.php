<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Domain\Entity\Queue;

use Domain\Entity\Entity;
use Domain\Value\Queue\Priority as QueuePriority;
use Domain\Value\Queue\Type as QueueType;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
interface Mail extends Entity
{
    /**
     * @return mixed
     */
    public function getType();

    /**
     * @param int $type
     * @return mixed
     */
    public function setType($type = QueueType::SUBSCRIPTION);

    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @param string $content
     * @return mixed
     */
    public function setContent($content = '');

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param string $title
     * @return mixed
     */
    public function setTitle($title = '');

    /**
     * @return mixed
     */
    public function getDestination();

    /**
     * @param string $destination
     * @return mixed
     */
    public function setDestination($destination = '');

    /**
     * @return mixed
     */
    public function getPriority();

    /**
     * @param int $priority
     * @return mixed
     */
    public function setPriority($priority = QueuePriority::NORMAL);
}
