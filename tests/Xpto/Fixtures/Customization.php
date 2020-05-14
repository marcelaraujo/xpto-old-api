<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Value\Customization as CustomizationType;
use Xpto\Entity\Users\Customization as CustomizationModel;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Customization extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Loader
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $i = 1;

        while ($i <= 10) {
            $valor = [
                'send_with_enter' => true,
                'status' => CustomizationModel::ACTIVE,
                'type' => CustomizationType::CHAT,
                'id' => $i,
            ];

            $obj = new CustomizationModel();
            $obj->setStatus($valor['status']);
            $obj->setType($valor['type']);
            $obj->setSendWithEnter($valor['send_with_enter']);

            $manager->persist($obj);
            $manager->flush();

            $this->addReference('customization_' . $i, $obj);

            $i++;
        }
    }

    /**
     * Load order
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
