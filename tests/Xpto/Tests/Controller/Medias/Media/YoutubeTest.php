<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Medias\Media;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class YoutubeTest extends WebTestCase
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
                    'url' => 'https://www.youtube.com/watch?v=moSFlvxnbgk',
                ],
                [
                    'url' => 'http://youtu.be/ckAGKzTKsvw',
                ]
            ]
        ];
    }

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function invalidObjects()
    {
        return [
            [
                [
                    'url' => 'http://www.google.com.br',
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function postMediaWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('POST', '/media/youtube/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postMediaWithoutParametersAndWithoutAuthHeader()
    {
        $this->header = [];

        $client = $this->createClient();
        $client->request('POST', '/media/youtube/', [], [], $this->header);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postMediaWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/media/youtube/', $obj, [], $this->header);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider invalidObjects
     */
    public function postMediaWithFullParametersThrowsExceptionWhenUrlIsInvalid($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/media/youtube/', $obj, [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
}
