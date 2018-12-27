<?php

namespace AppTest\Integration\Endpoint\Ticket;

use AppTest\Integration\Support\Endpoint\EndpointTestCase;

class ListTicketTest extends EndpointTestCase
{

    public function testListAuthorsTickets()
    {
        $user = $this->registerTestUser();
        $userToken = $this->getUserAuthToken($user);

        $request = $this
            ->createRequest('/ticket/list')
            ->withMethod('POST')
            ->withHeader('Authorization', $userToken)
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(isset($responseBody['tickets']));
    }

}
