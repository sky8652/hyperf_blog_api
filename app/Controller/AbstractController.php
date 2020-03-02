<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;


    /**
     * @param     $msg
     * @param     $data
     * @param int $code
     * successful return
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function success($msg,$data=[],$code=1) {
        return $this->response->json([
            'msg'  => $msg,
            'data' => $data,
            'code' => $code
        ]);
    }


    public function admin()
    {
        return Context::get('admin');
    }
}
