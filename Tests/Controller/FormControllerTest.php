<?php

namespace Netvlies\Bundle\FormBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormControllerTest extends WebTestCase
{
    public function testShowForm()
    {
        $client = static::createClient();
        $client->request('GET', '/form/show/1');

        return $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
