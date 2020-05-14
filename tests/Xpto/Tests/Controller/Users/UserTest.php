<?php
/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @copyright proprietary
 */
namespace Application\Tests\Controller\Users;

use Xpto\Tests\ApplicationControllerTestCase;
use Domain\Value\Category;
use Domain\Value\Gender;
use Domain\Value\Work\Area as WorkArea;
use Domain\Value\Work\Type as WorkType;
use Silex\WebTestCase;

/**
 * User Controller test case
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class UserTest extends WebTestCase
{
    use ApplicationControllerTestCase;

    /**
     * Data Provider
     *
     * @return multitype:multitype:multitype:string
     */
    public function validObjects()
    {
        $objMale = [
            "name" => "Ciclano de Tal",
            "email" => "teste-" . sha1(uniqid()) . "@teste.net",
            "password" => "lalala",
            "birth" => "2014-11-28T17:49:01-0200",
            "gender" => Gender::MALE,
            "nickname" => sha1(uniqid()),
            "biorelease" => "um cara",
            "fullrelease" => "um cara com um release",
            "site" => "marcelaraujo.com.br",
            "work_type" => WorkType::PRODUCER,
            "work_area" => WorkArea::FILMMAKER,
            "category" => Category::BUSINESS,
            'location_born' => 'Florianópolis - SC',
            'location_live' => 'Florianópolis - SC',
            'token' => 'dcf4b8b7-773b-4cc3-82d5-efc48db59f00',
        ];

        $objFemale = [
            "name" => "Fulana de tal",
            "email" => "teste-" . sha1(uniqid()) . "@teste.net",
            "password" => "lalala",
            "birth" => "2014-11-28T17:49:01-0200",
            "gender" => Gender::FEMALE,
            "nickname" => sha1(uniqid()),
            "biorelease" => "alguem qualquer",
            "fullrelease" => "preguica de escrever um release",
            "site" => "fulana.com.br",
            "work_type" => WorkType::AGENCY,
            "work_area" => WorkArea::MODEL,
            "category" => Category::FASHION,
            'location_born' => 'Florianópolis - SC',
            'location_live' => 'Florianópolis - SC',
            'token' => '894ad86f-6451-475d-8778-39af5b3906d9',
        ];

        return [
            [
                $objMale
            ],
            [
                $objFemale
            ]
        ];
    }

    /**
     * @test
     */
    public function getUserWithoutAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserWithAuthHeader()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/', [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByNickname()
    {
        $validUserProfiles = ['test2', 'test3'];

        $validProfile = $validUserProfiles[array_rand($validUserProfiles, 1)];

        $client = $this->createClient();
        $client->request('GET', '/user/' . $validProfile, [], [], $this->header);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByNicknameIsNotLogged()
    {
        $validUserProfiles = ['test1', 'test2', 'test3'];

        $client = $this->createClient();
        $client->request('GET', '/user/' . $validUserProfiles[array_rand($validUserProfiles, 1)]);

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByIdThrowsExceptionWhenUserIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/0', [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByIdThrowsExceptionWhenUserIsNotLogged()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/0');

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByNickNameThrowsExceptionWhenUserIsInvalid()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/' . uniqid(), [], [], $this->header);

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function getUserByNickNameThrowsExceptionWhenUserIsNotLogged()
    {
        $client = $this->createClient();
        $client->request('GET', '/user/' . uniqid());

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function putUserWithFullParameters($obj)
    {
        $client = $this->createClient();
        $client->request('PUT', '/user/', $obj, [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function putUserWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('PUT', '/user/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function deleteUserWithoutParameters()
    {
        $client = $this->createClient();
        $client->request('DELETE', '/user/', [], [], $this->header);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider validObjects
     */
    public function deleteUserWithParameters($obj)
    {
        $this->header['HTTP_Authorization'] = 'TOKEN ' . $obj['token'];

        $client = $this->createClient();
        $client->request('DELETE', '/user/', $obj, [], $this->header);

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
