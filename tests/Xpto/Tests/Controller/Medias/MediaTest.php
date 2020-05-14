<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias;

use Xpto\Tests\ApplicationControllerTestCase;
use Domain\Value\MediaType;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class MediaTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        return [
            [
                [
                    'detail' => json_encode(['tmp' => 'none']),
                    'url' => 'http://localhost',
                    'type' => MediaType::IMAGE,
                    'id' => 1,
                ],
            ],
            [
                [
                    'detail' => json_encode(['tmp' => 'none']),
                    'url' => 'http://localhost',
                    'type' => MediaType::SOUNDCLOUD,
                    'id' => 2,
                ],
            ],
            [
                [
                    'detail' => json_encode(['tmp' => 'none']),
                    'url' => 'http://localhost',
                    'type' => MediaType::YOUTUBE,
                    'id' => 3,
                ],
            ],
            [
                [
                    'detail' => json_encode(['tmp' => 'none']),
                    'url' => 'http://localhost',
                    'type' => MediaType::VIMEO,
                    'id' => 4,
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function getAll()
    {
        $client = $this->createClient();
        $client->request('GET', '/media/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getMediaByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/media/' . uniqid(), [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postMediaWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('POST', '/media/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postMediaWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/media/', $obj, [], $this->header, json_encode($obj));

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteMediaWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/media/', [], [], $this->header);

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function deleteMediaWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('DELETE', '/media/' . $obj['id'], [], [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
