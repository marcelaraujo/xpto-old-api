<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Factory\Users;

use Domain\Entity\Users\Profile as ProfileModel;
use Domain\Value\Customization as CustomizationType;
use Xpto\Entity\Users\Customization as CustomizationModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profile Factory
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
abstract class Customization
{
    /**
     *
     * @param Request $profile
     * @return ProfileModel
     */
    public static function create(Request $profile)
    {
        $obj = new CustomizationModel();
        $obj->setStatus(CustomizationModel::ACTIVE);
        $obj->setSendWithEnter(true);
        $obj->setType(CustomizationType::CHAT);

        return $obj;
    }
}
