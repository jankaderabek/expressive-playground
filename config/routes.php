<?php

declare(strict_types=1);

use App\Ticket\Endpoint\AuthorList\ListHandler;
use App\Ticket\Endpoint\Create\CreateHandler;
use App\User\Authentication\Endpoint\Login\LoginHandler;
use App\User\Authentication\Endpoint\Login\LoginRequest;
use Psr\Container\ContainerInterface;
use RequestValidation\Middleware\CallableMiddlewareRequestFactory;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->post(
        '/auth/register',
        [
            \App\User\Authentication\Endpoint\Registration\RegisterHandler::class,
        ]
    );

    $app->post(
        '/auth/login',
        [
            CallableMiddlewareRequestFactory::create(LoginRequest::class),
            LoginHandler::class,
        ],
        'auth.login'
    );

    $app->get(
        '/auth/profile',
        [
            \App\User\Authentication\Middleware\AuthenticatedMiddleware::class,
            \App\User\Authentication\Endpoint\ProfileHandler::class,
        ]
    );

    $app->post('/ticket/create', CreateHandler::class);
    $app->get('/ticket/list', ListHandler::class);
};
