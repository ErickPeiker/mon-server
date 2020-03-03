<?php

namespace App\Base\Test\Controller;

abstract class CrudControllerTest extends BaseControllerTest
{
    public function testList()
    {
        $data = $this->getRepositoryTest()->getFlushedMockArray();

        $this->client->xmlHttpRequest(
            'GET',
            $this->getRoute()
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, count(json_decode($this->client->getResponse()->getContent())));
    }

    public function testShow()
    {
        $data = $this->getRepositoryTest()->getFlushedMockArray();

        $this->client->xmlHttpRequest(
            'GET',
            $this->getRoute().'/'.$data['id']
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($data['id'], json_decode($this->client->getResponse()->getContent())->id);
    }

    public function testCreate()
    {
        $data = $this->getRepositoryTest()->getMockArray();

        $this->client->xmlHttpRequest(
            'POST',
            $this->getRoute(),
            $data
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertNotNull(json_decode($this->client->getResponse()->getContent())->id);
    }

    public function testUpdate()
    {
        $flushedData = $this->getRepositoryTest()->getFlushedMockArray();
        $data = $this->getRepositoryTest()->getMockArray();
        $data['id'] = $flushedData['id'];

        $this->client->xmlHttpRequest(
            'PUT',
            $this->getRoute().'/'.$data['id'],
            $data
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($flushedData['id'], json_decode($this->client->getResponse()->getContent())->id);
    }

    public function testDelete()
    {
        $flushedData = $this->getRepositoryTest()->getFlushedMockArray();

        $this->client->xmlHttpRequest(
            'DELETE',
            $this->getRoute().'/'.$flushedData['id']
        );

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }
}
