<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\View;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Album Controller
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Json extends Response
{
    /**
     * @inheritDoc
     */
    public function __construct($content = '', $status = Response::HTTP_OK)
    {
        $data = [
            'data' => $content,
            'code' => $status
        ];

        parent::__construct($this->serialize($data, 'json'), $status, ['Content-type' => 'application/json']);
    }

    /**
     *
     * @param mixed $data
     * @param string $type
     * @return mixed
     */
    public function serialize($data, $type)
    {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->serialize($data, $type);
    }
}
