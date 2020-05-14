<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Connections;

use Xpto\Tests\ApplicationControllerTestCase;
use Silex\WebTestCase;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class ConnectionTest extends WebTestCase
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
                    'source' => 1,
                    'destination' => 2,
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
        $client->request('GET', '/connection/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getAllWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/connection/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getConnectionByIdThrowsExceptionWhenIdIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/connection/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getConnectionByIdThrowsExceptionWhenIdIsInvalidAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/connection/' . uniqid());

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postConnectionWithoutParametersAndWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/connection/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function postConnectionWithoutParametersAndWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('POST', '/connection/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function postConnectionWithFullParametersWithoutAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/connection/', $obj, [], [], json_encode($obj));

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }


    /**
     * @test
     * @dataProvider validObjects
     */
    public function postConnectionWithFullParametersAndAuthHeader($obj)
    {
        $client = $this->createClient();
        $client->request('POST', '/connection/', $obj, [], $this->header, json_encode($obj));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
