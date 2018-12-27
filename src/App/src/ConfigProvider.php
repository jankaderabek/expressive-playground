<?php

declare(strict_types=1);

namespace App;

use App\Ticket\Endpoint\AuthorList\ListHandler;
use App\Ticket\Endpoint\Create\CreateHandler;
use App\User\Authentication\Endpoint\Login\LoginHandler;
use App\User\Authentication\Endpoint\ProfileHandler;
use App\User\Authentication\Endpoint\Registration\RegisterHandler;
use App\User\Authentication\Middleware\AuthenticatedMiddleware;
use App\User\Authentication\Model\ApiTransfer\AuthenticatedUserTokenService;
use App\User\Authentication\Model\ApiTransfer\UserExchangeService;
use App\User\Authentication\Model\Authenticator\Authenticator;
use App\User\Authentication\Model\Authenticator\PasswordService;
use App\User\Authentication\Model\Registration\UserRegistrar;
use App\User\Model\UserRepository;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'factories' => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
                RegisterHandler::class => ReflectionBasedAbstractFactory::class,
                LoginHandler::class => ReflectionBasedAbstractFactory::class,
                ProfileHandler::class => ReflectionBasedAbstractFactory::class,
                AuthenticatedMiddleware::class => ReflectionBasedAbstractFactory::class,
                AuthenticatedUserTokenService::class => ReflectionBasedAbstractFactory::class,
                UserExchangeService::class => ReflectionBasedAbstractFactory::class,
                UserRepository::class => ReflectionBasedAbstractFactory::class,
                UserRegistrar::class => ReflectionBasedAbstractFactory::class,
                PasswordService::class => ReflectionBasedAbstractFactory::class,
                Authenticator::class => ReflectionBasedAbstractFactory::class,
                \App\Ticket\Model\TicketService::class => ReflectionBasedAbstractFactory::class,
                \App\Ticket\Model\TicketFacade::class => ReflectionBasedAbstractFactory::class,
                CreateHandler::class => ReflectionBasedAbstractFactory::class,
                ListHandler::class => ReflectionBasedAbstractFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => [__DIR__ . '/../templates/app'],
                'error' => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
