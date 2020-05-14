<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests\Service\Medias;

use Domain\Entity\Medias\Media\Like as LikeModelInterface;
use Xpto\Service\Medias\Media\Like as LikeService;
use Xpto\Tests\CreateDatabaseMock as CreateEmMock;
use Xpto\Tests\ChangeProtectedAttribute;
use Mockery;
use PHPUnit_Framework_TestCase;

/**
 * Like media service test case.
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class LikeTest extends PHPUnit_Framework_TestCase
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
     * @covers \Xpto\Service\Medias\Media\Like::save()
     * @covers \Xpto\Service\Service::__construct()
     * @covers \Xpto\Service\Service::setEm()
     * @covers \Doctrine\ORM\EntityManager::persist()
     * @covers \Doctrine\ORM\EntityManager::flush()
     */
    public function save()
    {
        $likeModel = Mockery::mock(LikeModelInterface::class);
        $likeModel->shouldReceive('isDeleted')->andReturn(false)->byDefault();

        $likeService = new LikeService();

        $this->modifyAttribute($likeService, 'em', $this->getDefaultEmMock());

        $this->assertSame($likeModel, $likeService->save($likeModel));
    }

    /**
     * @test
     * @covers Xpto\Service\Medias\Media\Like::delete()
     * @covers Xpto\Entity\Medias\Media\Like::isDeleted()
     * @covers Xpto\Entity\Medias\Media\Like::setStatus()
     * @covers Xpto\Service\Medias\Media\Like::save()
     * @covers Xpto\Service\Service::__construct()
     * @covers Xpto\Service\Service::setEm()
     * @covers Doctrine\ORM\EntityManager::persist()
     * @covers Doctrine\ORM\EntityManager::flush()
     */
    public function delete()
    {
        $likeModel = Mockery::mock(LikeModelInterface::class);
        $likeModel->shouldReceive('isDeleted')->andReturn(false)->byDefault();
        $likeModel->shouldReceive('setStatus')->andReturn(null)->byDefault();

        $likeService = new LikeService();

        $this->modifyAttribute($likeService, 'em', $this->getDefaultEmMock());

        $result = $likeService->delete($likeModel);

        $this->assertTrue($result);
    }
}
