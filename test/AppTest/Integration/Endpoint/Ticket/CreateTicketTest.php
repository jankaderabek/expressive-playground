<?php

namespace AppTest\Integration\Endpoint\Ticket;

class CreateTicketTest extends \AppTest\Integration\Support\Endpoint\EndpointTestCase
{

    public function testCreateUser()
    {
        $userToken = $this->getUserAuthToken($this->registerTestUser());

        $request = $this
            ->createRequest('/ticket/create')
            ->withMethod('POST')
            ->withParsedBody([
                'title' => 'Title',
            ])
            ->withHeader('Authorization', $userToken)
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(isset($responseBody['id']));
    }

}
