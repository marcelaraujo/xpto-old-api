<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Medias;

use Xpto\Entity\Medias\Media as MediaModel;
use Xpto\Service\Medias\Media as MediaService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Media service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class MediaTest extends PHPUnit_Framework_TestCase
{
    /**
     * @see CreateEmMock
     */
    use CreateEmMock;

    /**
     * @see ChangeProtectedAttribute
     */
    use ChangeProtectedAttribute;

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Medias\Media::__construct()
     * @covers Xpto\Entity\Medias\Media::setStatus()
     * @covers Xpto\Entity\Medias\Media::isDeleted()
     * @covers Xpto\Service\Medias\Media::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function save()
    {
        $mediaService = new MediaService();

        $this->modifyAttribute($mediaService, 'em', $this->getDefaultEmMock());

        $mediaModel = new MediaModel();

        $result = $mediaService->save($mediaModel);

        $this->assertSame($mediaModel, $result);
    }

    /**
     * @test
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     * @covers Xpto\Entity\Entity::setStatus()
     * @covers Xpto\Entity\Medias\Media::__construct()
     * @covers Xpto\Entity\Medias\Media::setStatus()
     * @covers Xpto\Entity\Medias\Media::isDeleted()
     * @covers Xpto\Service\Medias\Media::delete()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     */
    public function delete()
    {
        $mediaModel = new MediaModel();

        $mediaService = new MediaService();

        $this->modifyAttribute($mediaService, 'em', $this->getDefaultEmMock());

        $result = $mediaService->delete($mediaModel);

        $this->assertTrue($result);
    }
}
