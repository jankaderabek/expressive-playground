<?php

declare(strict_types=1);

namespace App;

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
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'factories'  => [
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,
				\App\Auth\Handler\RegisterHandler::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
				\App\Auth\Handler\LoginHandler::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
				\App\Auth\Handler\ProfileHandler::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
                \App\Auth\Middleware\AutheticatedMiddleware::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
                \App\Auth\User\AuthenticatedUserTokenService::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
                \App\Auth\User\UserExchangeService::class => \Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
