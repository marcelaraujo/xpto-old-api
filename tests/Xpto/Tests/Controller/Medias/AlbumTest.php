<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias;

use Xpto\View\Json as View;
use Xpto\Tests\ApplicationControllerTestCase;
use Domain\Value\AlbumType;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class AlbumTest extends WebTestCase
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
                    'user' => 1,
                    'type' => AlbumType::COMMON,
                    'title' => 'Common album',
                    'cover' => 1,
                    'nickname' => 'teste1',
                ]
            ],
            [
                [
                    'user' => 1,
                    'type' => AlbumType::COVER,
                    'title' => 'Cover album',
                    'cover' => 0,
                    'nickname' => 'teste1',
                ]
            ],
            [
                [
                    'user' => 1,
                    'type' => AlbumType::PROFILE,
                    'title' => 'Profile album',
                    'cover' => 0,
                    'nickname' => 'teste1',
                ]
            ],
            [
                [
                    'user' => 2,
                    'type' => AlbumType::COMMON,
                    'title' => 'Common album',
                    'cover' => 1,
                    'nickname' => 'teste2',
                ]
            ],
            [
                [
                    'user' => 2,
                    'type' => AlbumType::COVER,
                    'title' => 'Cover album',
                    'cover' => 0,
                    'nickname' => 'teste2',
                ]
            ],
            [
                [
                    'user' => 2,
                    'type' => AlbumType::PROFILE,
                    'title' => 'Profile album',
                    'cover' => 0,
                    'nickname' => 'teste2',
                ]
            ],
            [
                [
                    'user' => 3,
                    'type' => AlbumType::COMMON,
                    'title' => 'Common album',
                    'cover' => 1,
                    'nickname' => 'teste1',
                ]
            ],
            [
                [
                    'user' => 3,
                    'type' => AlbumType::COVER,
                    'title' => 'Cover album',
                    'cover' => 0,
                    'nickname' => 'teste3',
                ]
            ],
            [
                [
                    'user' => 3,
                    'type' => AlbumType::PROFILE,
                    'title' => 'Profile album',
                    'cover' => 0,
                    'nickname' => 'teste3',
                ]
            ],
        ];
    }

    /**
     * @test
     */
    public function getAllWithHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/', [], [], $this->header);

        $this->assertEquals(View::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/');

        $this->assertEquals(View::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAlbumByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/0', [], [], $this->header);

        $this->assertEquals(View::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAlbumByIdThrowsExceptionWhenIdIsInvalidAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/album/0');

        $this->assertEquals(View::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAlbumWithoutParametersAndWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/album/', [], [], $this->header);

        $this->assertEquals(View::HTTP_INTERNAL_SERVER_ERROR, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postAlbumWithoutParametersAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/album/');

        $this->assertEquals(View::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postAlbumWithFullParametersWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/album/', $obj, [], [], json_encode($obj));

        $this->assertEquals(View::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postAlbumWithFullParametersAndAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/album/', $obj, [], $this->header, json_encode($obj));

        $this->assertEquals(View::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
