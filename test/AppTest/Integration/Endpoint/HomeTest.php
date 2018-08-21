<?php declare(strict_types=1);

namespace AppTest\Integration\Endpoint\Support;

use AppTest\Integration\Support\Endpoint\EndpointTestCase;

class HomeTest extends EndpointTestCase
{

    public function testHomepage()
    {
        $request = $this->createRequest('/');

        $response = $this->send($request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
