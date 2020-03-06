<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DebugMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /*
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(ContainerInterface $container,LoggerFactory $loggerFactory)
    {
        $this->container = $container;
        $this->logger    = $loggerFactory->get('log','default');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $time = microtime(true);
        $response = $handler->handle($request);

        if (config('app_debug', false) === false) {
            return $response;
        }

        $request = $this->container->get(RequestInterface::class);
        $result = $response->getBody()->getContents();

        // 日志
        $time = microtime(true) - $time;
        $debug = 'URL: ' . $request->getUri() . PHP_EOL;
        $debug .= 'TIME: ' . $time . PHP_EOL;
        $debug .= 'PARAMS: ' . $request->getBody()->getContents() . PHP_EOL;
        $debug .= 'RESPONSE: ' . $result . PHP_EOL;

        if ($time > 1) {
            $this->logger->error($debug);
        } else {
            $this->logger->info($debug);
        }
        return $response;
    }
}
