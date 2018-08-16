<?php

declare(strict_types=1);

namespace RequestValidation;

use RequestValidation\Middleware\InvalidRequestErrorHandler;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

/**
 * The configuration provider for the RequestValidation module
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
            'invokables' => [
            ],
            'factories'  => [
                InvalidRequestErrorHandler::class => ReflectionBasedAbstractFactory::class,
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
                'requestvalidation'    => [__DIR__ . '/../templates/'],
            ],
        ];
    }
}
