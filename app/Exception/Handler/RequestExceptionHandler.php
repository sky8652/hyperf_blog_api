<?php
namespace App\Exception\Handler;

use App\Exception\WrongRequestException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Logger\LoggerFactory;
use Hyperf\RateLimit\Exception\RateLimitException;
use Hyperf\Validation\ValidationException;
use Phper666\JwtAuth\Exception\TokenValidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class RequestExceptionHandler extends  ExceptionHandler
{

    /**
     * @Inject()
     * @var \Hyperf\HttpServer\Contract\ResponseInterface
     */
    private $httpResponse;

    /**
     * @Inject()
     * @var LoggerFactory
     */
    private $loggerFactory;

    /**
     * @param Throwable         $throwable
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 格式化输出
        $data = [
            'code' => 400,
            'msg' => $throwable->getMessage(),
        ];

        if ($throwable instanceof ValidationException ) {
            // 格式化输出
            $data['msg']  = $throwable->validator->errors()->first();
        }

        if ( $throwable instanceof RateLimitException ) {
            $data['msg'] = '您的速度太快了,请稍后再访问！';
        }

        if ($throwable instanceof TokenValidException) {
            $data['msg']  = $throwable->getMessage();
            $data['code'] = 402;  //未登录code
        }

        if ($throwable instanceof \ErrorException ) {
            $data['msg'] = '系统异常!';
            $log = $this->loggerFactory->get('log','default');
            $log->error($throwable->getMessage()."\n".$throwable->getFile()."\n".$throwable->getCode());
        }



        // 阻止异常冒泡
        $this->stopPropagation();

        return $this->httpResponse->json($data);
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
