<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BooksControllerTest extends WebTestCase
{
    public function testGetVolumes()
    {
        $client = $this->createClient();
        
        $crawler = $client->request('GET', 'http://tmunteanu.go.ro:181/api/v1/volume?q=all');
        
        $response = $client->getResponse();
        
        $this->assertSame(200, $response->getStatusCode());
        
        $responseData = json_decode($response->getContent(), true);
        
        $this->assertTrue(count($responseData) > 0);
    }
}
