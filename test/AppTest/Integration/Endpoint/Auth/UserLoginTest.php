<?php declare(strict_types=1);

namespace AppTest\Integration\Endpoint\Support\Auth;

use App\User\Authentication\Model\Registration\UserRegistrar;
use AppTest\Integration\Support\Endpoint\EndpointTestCase;

class UserLoginTest extends EndpointTestCase
{

    public function testLoginWithUndefinedEmail(): void
    {
        $request = $this
            ->createRequest('/auth/login')
            ->withMethod('POST')
            ->withParsedBody([
                'email' => 'user@email.com',
                'password' => 'password'
            ])
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Invalid credentials', $responseBody['message']);
    }


    public function testLoginWithInvalidPassword(): void
    {
        /** @var UserRegistrar $userRegistrar */
        $userRegistrar = $this->container->get(UserRegistrar::class);
        $userRegistrar->register('user@email.com', 'password');

        $request = $this
            ->createRequest('/auth/login')
            ->withMethod('POST')
            ->withParsedBody([
                'email' => 'user@email.com',
                'password' => 'invalid_password'
            ])
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('Invalid credentials', $responseBody['message']);
    }


    public function testLoginWithValidCredentials(): void
    {
        /** @var UserRegistrar $userRegistrar */
        $userRegistrar = $this->container->get(UserRegistrar::class);
        $userRegistrar->register('user@email.com', 'password');

        $request = $this
            ->createRequest('/auth/login')
            ->withMethod('POST')
            ->withParsedBody([
                'email' => 'user@email.com',
                'password' => 'password'
            ])
        ;

        $response = $this->send($request);
        $responseBody = $this->getBody($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($responseBody['token']);
    }
}
