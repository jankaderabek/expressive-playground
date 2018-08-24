<?php

declare(strict_types=1);

namespace App;

use App\User\Authentication\Middleware\AuthenticatedMiddleware;
use App\User\Authentication\Model\ApiTransfer\AuthenticatedUserTokenService;
use App\User\Authentication\Model\ApiTransfer\UserExchangeService;
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
                \App\User\Authentication\Handler\RegisterHandler::class => ReflectionBasedAbstractFactory::class,
                \App\User\Authentication\Handler\LoginHandler::class => ReflectionBasedAbstractFactory::class,
                \App\User\Authentication\Handler\ProfileHandler::class => ReflectionBasedAbstractFactory::class,
                AuthenticatedMiddleware::class => ReflectionBasedAbstractFactory::class,
                AuthenticatedUserTokenService::class => ReflectionBasedAbstractFactory::class,
                UserExchangeService::class => ReflectionBasedAbstractFactory::class,
                \App\User\Model\UserRepository::class => ReflectionBasedAbstractFactory::class
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
