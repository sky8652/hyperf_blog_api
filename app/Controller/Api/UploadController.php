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

namespace App\Controller\Api;
use App\Controller\AbstractController;
use App\Services\Api\UploadService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;


class UploadController extends AbstractController
{

    /**
     * @Inject()
     * @var UploadService
     */
    protected $uploadService;


    public function image(RequestInterface $request)
    {
        return $this->success('成功', $this->uploadService->image($request->file('image')));
    }
}
