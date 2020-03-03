<?php

namespace App\Base\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\Repository\UserRepositoryTest;

abstract class BaseControllerTest extends WebTestCase
{
    protected $client = null;
    private $apiToken = null;

    abstract public function getRepositoryTest();

    public function setUp()
    {
        $this->client = static::createClient();
        $this->apiToken = $this->login();

        $this->client->setServerParameter('HTTP_AUTHORIZATION', $this->apiToken);
    }

    public function login()
    {
        $data = (new UserRepositoryTest())->getFlushedMockObject();

        $this->client->request(
            'POST',
            '/login',
            [
                'email' => $data->getEmail(),
                'password' => '123123',
            ]
        );

        return json_decode($this->client->getResponse()->getContent())->apiToken;
    }
}
