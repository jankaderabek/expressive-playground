<?php declare(strict_types=1);

namespace AppTest\Integration\Endpoint\Support\Auth;

use AppTest\Integration\Support\Endpoint\EndpointTestCase;

class UserRegistrationTest extends EndpointTestCase
{

    public function testCreateUser()
    {
        $request = $this
            ->createRequest('/auth/register')
            ->withMethod('POST')
            ->withParsedBody([
                'email' => 'user@email.com',
                'password' => 'password'
            ])
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $responseBody['status']);
    }

    public function testCreateUserWithExistingEmail()
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->container->get(\Doctrine\ORM\EntityManager::class);
        $entityManager->persist(new \App\Entity\User('existing@email.com', 'password'));
        $entityManager->flush();

        $request = $this
            ->createRequest('/auth/register')
            ->withMethod('POST')
            ->withParsedBody([
                'email' => 'existing@email.com',
                'password' => 'password'
            ])
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertNotEmpty($responseBody['message']);
    }
}
