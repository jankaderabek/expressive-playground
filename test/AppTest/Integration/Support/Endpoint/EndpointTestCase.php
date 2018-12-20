<?php declare(strict_types = 1);

namespace AppTest\Integration\Support\Endpoint;

use App\User\Authentication\Model\ApiTransfer\UserExchangeService;
use App\User\Authentication\Model\Registration\UserRegistrar;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use \PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Router\RouteCollector;
use Zend\HttpHandlerRunner\RequestHandlerRunner;
use Zend\Expressive\ApplicationPipeline;

abstract class EndpointTestCase extends TestCase
{

    private const CONFIG_DIRECTORY = __DIR__ . '/../../../../../config/';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var FakeEmitter
     */
    protected $emitter;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    private $request;

    protected function setUp()
    {
        $this->createApp();
    }

    protected function send(RequestInterface $request): ResponseInterface
    {
        $this->request = $request;

        $this->app->run();

        return $this->emitter->getResponse();
    }

    protected function createRequest(string $path): ServerRequest
    {
        $request = new ServerRequest();
        $uri = new Uri();

        return $request->withUri($uri->withPath($path));
    }

    protected function getBody(ResponseInterface $response): ?array
    {
        return json_decode((string)$response->getBody(), true);
    }

    private function createApp(): void
    {
        $container = require self::CONFIG_DIRECTORY . 'container.php';

        /** @var \Zend\Expressive\Application $app */
        $app = $container->get(\Zend\Expressive\Application::class);
        $factory = $container->get(\Zend\Expressive\MiddlewareFactory::class);


        (require self::CONFIG_DIRECTORY . 'pipeline.php')($app, $factory, $container);
        (require self::CONFIG_DIRECTORY . 'routes.php')($app, $factory, $container);

        $requestHandlerRunner = new RequestHandlerRunner(
            $container->get(ApplicationPipeline::class),
            $this->emitter = new FakeEmitter(),
            function () {
                return $this->request;
            },
            function () {
                return $this->request;
            }
        );

        $this->container = $container;
        $this->app = new Application(
            $container->get(MiddlewareFactory::class),
            $container->get(ApplicationPipeline::class),
            $container->get(RouteCollector::class),
            $requestHandlerRunner
        );

        $this->createDatabase();
    }

    private function createDatabase(): void
    {
        $entityManager = $this->container->get(EntityManager::class);

        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);

        $schemaTool->dropDatabase();
        $schemaTool->createSchema($metadata);
    }


    protected function getUserAuthToken(): string
    {
        /** @var UserRegistrar $userRegistrar */
        $userRegistrar = $this->container->get(UserRegistrar::class);

        $user = $userRegistrar->register('test@user.com', 'Password123');

        /** @var UserExchangeService $userExchangeService */
        $userExchangeService = $this->container->get(UserExchangeService::class);

        $userToken = $userExchangeService->createToken($user);

        return 'Bearer ' . $userToken;
    }

}
