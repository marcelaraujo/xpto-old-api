<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Medias\Media;

use Xpto\Entity\Medias\Media\Detail as DetailModel;

/**
 * The Detail Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Detail
{
    /**
     * @param array $data
     * @return DetailModel
     */
    public static function create(array $data)
    {
        $detail = new DetailModel();
        $detail->setHeight($data['height']);
        $detail->setWidth($data['width']);
        $detail->setUrl($data['url']);
        $detail->setSize($data['size']);

        return $detail;
    }
}
